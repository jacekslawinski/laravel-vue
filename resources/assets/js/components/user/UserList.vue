<template>
  <v-card light class="ma-4">
    <v-system-bar />
    <v-toolbar flat>
      <v-toolbar-title>
        {{ $t('user.listTitle') }}
      </v-toolbar-title>
      <v-spacer />
    </v-toolbar>
    <v-banner
      single-line
      class="text-right"
    >
      <v-btn
        color="primary"
        @click="addUser"
      >
        {{ $t('user.addNewUser') }}
      </v-btn>
    </v-banner>
    <v-card-text>
      <v-data-table
        light
        dense
        :headers="headers"
        :items="users"
        item-key="id"
        :loading="loading"
        :loading-text="$t('dataTable.loading')"
        :no-data-text="$t('dataTable.noData')"
      >
        <template v-slot:item.hardware="{ item }">
          <div
            v-for="(userHardware, index) in item.userHardwares"
            :key="index"
          >
            {{ userHardware.hardware.name }}
          </div>
        </template>
        <template v-slot:item.operations="{ item }">
          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                light
                v-on="on"
                @click="updateUser(item)"
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
                @click="confirmDeleteUser(item)"
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
    <user-edit
      v-if="showEditDialog"
      :show.sync="showEditDialog"
      :user="currentUser"
      @[needRefreshEvent]="fetch"
    />
  </v-card>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Confirm } from '@component/common/dialogs/Confirm';
import AppDataTableHeader from '@root/shared/AppDataTableHeader';
import { AppEvents } from '@root/shared/AppEvents';
import { User, UserInterface } from './User';
import UserClient from './UserClient';
import UserEdit from './UserEdit.vue';

@Component({
  components: {
    UserEdit
  }
})
class UserList extends Vue {
  private loading = false;
  private headers!: AppDataTableHeader[];
  private users: User[] = [];
  private apiClient!: UserClient;
  private currentUser: User|null = null;
  private showEditDialog = false;
  private needRefreshEvent = AppEvents.NEED_REFRESH;
  private confirmDelete!: Confirm;

  created() {
    this.headers = [
      { text: this.$t('user.userId'), value: 'id', sortable: true, align: 'end', width: '1px', cellClass: 'text-no-wrap', class: 'text-no-wrap'},
      { text: this.$t('user.firstname'), value: 'firstname', sortable: true, align: 'start'},
      { text: this.$t('user.lastname'), value: 'lastname', sortable: true, align: 'start'},
      { text: this.$t('user.email'), value: 'email', sortable: true, align: 'start'},
      { text: this.$t('user.hardware'), value: 'hardware', sortable: true, align: 'start'},
      { text: this.$t('common.actions'), value: 'operations', sortable: false, align: 'center', width: '1px', cellClass: 'text-no-wrap', class: 'text-no-wrap'}
    ];
    this.apiClient = new UserClient();
    this.confirmDelete = new Confirm({
      title: this.$t('common.confirmation'),
      message: this.$t('user.confirmDeleteMessage'),
      confirmText: this.$t('common.yes'),
      cancelText: this.$t('common.no'),
      confirmAction: this.deleteUser,
    });
  }

  mounted() {
    this.fetch();
  }

  private fetch() {
    this.loading = true;
    this.users = [];
    this.apiClient.getUsers()
      .then((data: any) => {
        data.result.forEach((user: UserInterface) => {
          this.users.push(new User(user));
        })
      })
      .finally(() => {
        this.loading = false;
      });
  }

  private addUser() {
    this.currentUser = new User({});
    this.showEditDialog = true;
  }

  private updateUser(user: User) {
    this.currentUser = new User(user);
    this.showEditDialog = true;
  }

  private confirmDeleteUser(user: User) {
    this.confirmDelete.data = user;
    this.$root.$emit(AppEvents.SHOW_CONFIRM, this.confirmDelete);
  }

  private deleteUser(user: User) {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.deleteUser(user)
      .then(() => {
        this.fetch();
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      });
  }
}

export default UserList
</script>
