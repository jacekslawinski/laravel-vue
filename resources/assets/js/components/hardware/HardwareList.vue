<template>
  <v-card light class="ma-4">
    <v-system-bar />
    <v-toolbar flat>
      <v-toolbar-title>
        {{ $t('hardware.listTitle') }}
      </v-toolbar-title>
      <v-spacer />
    </v-toolbar>
    <v-banner
      single-line
      class="text-right"
    >
      <v-btn
        color="primary"
        @click="addHardware"
      >
        {{ $t('hardware.addNewHardware') }}
      </v-btn>
    </v-banner>
    <v-card-text>
      <v-data-table
        light
        dense
        :headers="headers"
        :items="hardwares"
        item-key="id"
        :loading="loading"
        :loading-text="$t('dataTable.loading')"
        :no-data-text="$t('dataTable.noData')"
      >
        <template v-slot:item.user="{ item }">
            {{ getUserFullname(item) }}
        </template>
        <template v-slot:item.operations="{ item }">
          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                light
                v-on="on"
                @click="updateHardware(item)"
              >
                <v-icon light>
                  mdi-square-edit-outline
                </v-icon>
              </v-btn>
            </template>
            <span>{{ $t('common.edit') }}</span>
          </v-tooltip>
          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                light
                v-on="on"
                @click="confirmDeleteHardware(item)"
              >
                <v-icon light>
                  mdi-trash-can-outline
                </v-icon>
              </v-btn>
            </template>
            <span>{{ $t('common.edit') }}</span>
          </v-tooltip>
          <v-tooltip
            top
            v-if="isHardwareInOffice(item)"
          >
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                light
                v-on="on"
                @click="leaseToUser(item)"
              >
                <v-icon light>
                  mdi-account-arrow-right-outline
                </v-icon>
              </v-btn>
            </template>
            <span>{{ $t('hardware.leaseToUser') }}</span>
          </v-tooltip>
          <v-tooltip
            top
            v-if="isHardwareInUser(item)"
          >
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                light
                v-on="on"
                @click="returnToOffice(item)"
              >
                <v-icon light>
                  mdi-clipboard-arrow-down-outline
                </v-icon>
              </v-btn>
            </template>
            <span>{{ $t('hardware.returnToOffice') }}</span>
          </v-tooltip>
        </template>
      </v-data-table>
    </v-card-text>
    <hardware-edit
      v-if="showEditDialog"
      :show.sync="showEditDialog"
      :hardware="currentHardware"
      :systems="systemList"
      @[needRefreshEvent]="fetch"
    />
    <user-hardware-add
      v-if="showAddUserDialog"
      :show.sync="showAddUserDialog"
      :hardware="currentHardware"
      @[needRefreshEvent]="fetch"
    />
  </v-card>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Confirm } from '@component/common/dialogs/Confirm';
import { System, SystemInterface } from '@component/system/System';
import SystemClient from '@component/system/SystemClient';
import AppDataTableHeader from '@root/shared/AppDataTableHeader';
import { AppEvents } from '@root/shared/AppEvents';
import { Hardware, HardwareInterface } from './Hardware';
import HardwareClient from './HardwareClient';
import HardwareEdit from './HardwareEdit.vue';
import UserHardwareAdd from './UserHardwareAdd.vue';

@Component({
  components: {
    HardwareEdit,
    UserHardwareAdd
  }
})
class HardwareList extends Vue {
  private loading = false;
  private headers!: AppDataTableHeader[];
  private hardwares: Hardware[] = [];
  private apiClient!: HardwareClient;
  private systemApiClient!: SystemClient;
  private currentHardware: Hardware|null = null;
  private showEditDialog = false;
  private showAddUserDialog = false;
  private needRefreshEvent = AppEvents.NEED_REFRESH;
  private confirmDelete!: Confirm;
  private systemList: System[] = [];

  created() {
    this.headers = [
      { text: this.$t('hardware.hardwareId'), value: 'id', sortable: true, align: 'end', width: '1px', cellClass: 'text-no-wrap', class: 'text-no-wrap'},
      { text: this.$t('hardware.name'), value: 'name', sortable: true, align: 'start'},
      { text: this.$t('hardware.serialNumber'), value: 'serialNumber', sortable: true, align: 'start'},
      { text: this.$t('hardware.productionMonth'), value: 'productionMonth', sortable: true, align: 'center'},
      { text: this.$t('hardware.localization'), value: 'user', sortable: true, align: 'center'},
      { text: this.$t('common.actions'), value: 'operations', sortable: false, align: 'center', width: '1px', cellClass: 'text-no-wrap', class: 'text-no-wrap'}
    ];
    this.apiClient = new HardwareClient();
    this.systemApiClient = new SystemClient();
    this.confirmDelete = new Confirm({
      title: this.$t('common.confirmation'),
      message: this.$t('hardware.confirmDeleteMessage'),
      confirmText: this.$t('common.yes'),
      cancelText: this.$t('common.no'),
      confirmAction: this.deleteHardware,
    });
  }

  mounted() {
    this.fetch();
    this.getSystems();
  }

  private fetch() {
    this.loading = true;
    this.hardwares = [];
    this.apiClient.getHardwares()
      .then((data: any) => {
        data.result.forEach((hardware: HardwareInterface) => {
          this.hardwares.push(new Hardware(hardware));
        })
      })
      .finally(() => {
        this.loading = false;
      });
  }

  private addHardware() {
    this.currentHardware = new Hardware({});
    this.showEditDialog = true;
  }

  private updateHardware(hardware: Hardware) {
    this.currentHardware = new Hardware(hardware);
    this.showEditDialog = true;
  }

  private confirmDeleteHardware(hardware: Hardware) {
    this.confirmDelete.data = hardware;
    this.$root.$emit(AppEvents.SHOW_CONFIRM, this.confirmDelete);
  }

  private deleteHardware(hardware: Hardware) {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.deleteHardware(hardware)
      .then(() => {
        this.fetch();
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      });
  }

  private getSystems() {
    this.systemList = [];
    this.systemApiClient.getSystems()
      .then((data: any) => {
        data.result.forEach((system: SystemInterface) => {
          this.systemList.push(new System(system));
        })
      });
  }

  private getUserFullname(hardware: Hardware) {
    return hardware.userHardware ? hardware.userHardware!.user.getFullname() : '';
  }

  private isHardwareInOffice(hardware: Hardware) {
    return hardware.userHardware === null;
  }

  private isHardwareInUser(hardware: Hardware) {
    return hardware.userHardware !== null;
  }

  private leaseToUser(hardware: Hardware) {
    this.currentHardware = new Hardware(hardware);
    this.showAddUserDialog = true;
  }

  private returnToOffice(hardware: Hardware) {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.deleteUserHardware(hardware)
      .then(() => {
        this.fetch();
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      });
  }
}

export default HardwareList
</script>
