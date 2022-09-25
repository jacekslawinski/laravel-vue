<template>
  <v-card light class="ma-4">
    <v-system-bar />
    <v-toolbar flat>
      <v-toolbar-title>
        {{ $t('system.listTitle') }}
      </v-toolbar-title>
      <v-spacer />
    </v-toolbar>
    <v-banner
      single-line
      class="text-right"
    >
      <v-btn
        color="primary"
        @click="addSystem"
      >
        {{ $t('system.addNewSystem') }}
      </v-btn>
    </v-banner>
    <v-card-text>
      <v-data-table
        light
        dense
        :headers="headers"
        :items="systems"
        item-key="id"
        :loading="loading"
        :loading-text="$t('dataTable.loading')"
        :no-data-text="$t('dataTable.noData')"
      >
        <template v-slot:item.operations="{ item }">
          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                light
                v-on="on"
                @click="updateSystem(item)"
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
                @click="confirmDeleteSystem(item)"
              >
                <v-icon light>
                  mdi-trash-can-outline
                </v-icon>
              </v-btn>
            </template>
            <span>{{ $t('common.edit') }}</span>
          </v-tooltip>
        </template>
      </v-data-table>
    </v-card-text>
    <system-edit
      v-if="showEditDialog"
      :show.sync="showEditDialog"
      :system="currentSystem"
      @[needRefreshEvent]="fetch"
    />
  </v-card>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Confirm } from '@component/common/dialogs/Confirm';
import AppDataTableHeader from '@root/shared/AppDataTableHeader';
import { AppEvents } from '@root/shared/AppEvents';
import { System, SystemInterface } from './System';
import SystemClient from './SystemClient';
import SystemEdit from './SystemEdit.vue';

@Component({
  components: {
    SystemEdit
  }
})
class SystemList extends Vue {
  private loading = false;
  private headers!: AppDataTableHeader[];
  private systems: System[] = [];
  private apiClient!: SystemClient;
  private currentSystem: System|null = null;
  private showEditDialog = false;
  private needRefreshEvent = AppEvents.NEED_REFRESH;
  private confirmDelete!: Confirm;

  created() {
    this.headers = [
      { text: this.$t('system.systemId'), value: 'id', sortable: true, align: 'end', width: '1px', cellClass: 'text-no-wrap', class: 'text-no-wrap'},
      { text: this.$t('system.name'), value: 'name', sortable: true, align: 'start'},
      { text: this.$t('common.actions'), value: 'operations', sortable: false, align: 'center', width: '1px', cellClass: 'text-no-wrap', class: 'text-no-wrap'}
    ];
    this.apiClient = new SystemClient();
    this.confirmDelete = new Confirm({
      title: this.$t('common.confirmation'),
      message: this.$t('system.confirmDeleteMessage'),
      confirmText: this.$t('common.yes'),
      cancelText: this.$t('common.no'),
      confirmAction: this.deleteSystem,
    });
  }

  mounted() {
    this.fetch();
  }

  private fetch() {
    this.loading = true;
    this.systems = [];
    this.apiClient.getSystems()
      .then((data: any) => {
        data.result.forEach((system: SystemInterface) => {
          this.systems.push(new System(system));
        });
      })
      .finally(() => {
        this.loading = false;
      });
  }

  private addSystem() {
    this.currentSystem = new System({});
    this.showEditDialog = true;
  }

  private updateSystem(system: System) {
    this.currentSystem = new System(system);
    this.showEditDialog = true;
  }

  private confirmDeleteSystem(system: System) {
    this.confirmDelete.data = system;
    this.$root.$emit(AppEvents.SHOW_CONFIRM, this.confirmDelete);
  }

  private deleteSystem(system: System) {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.deleteSystem(system)
      .then(() => {
        this.fetch();
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      });
  }
}

export default SystemList
</script>
