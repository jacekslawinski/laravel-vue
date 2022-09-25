<template>
  <v-app>
    <v-main>
      <v-tabs
        light
        right
      >
        <v-tab to="/user">Użytkownicy</v-tab>
        <v-tab to="/hardware">Sprzęt</v-tab>
        <v-tab to="/system">System</v-tab>
      </v-tabs>
      <router-view />
      <v-snackbar
        v-model="snackbar"
        light
        :timeout="timeout"
        top
        :color="color"
        content-class="black--text"
        elevation=24
      >
        {{ message }}
        <template v-slot:action="{}">
          <v-icon
            @click="snackbar = false"
          >
            mdi-close
          </v-icon>
        </template>
      </v-snackbar>
      <confirm-dialog />
      <progress-circular v-show="showProgress"></progress-circular>
    </v-main>
  </v-app>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import ConfirmDialog from '@component/common/dialogs/ConfirmDialog.vue';
import ProgressCircular from '@component/common/progress/ProgressCircular.vue';
import { AppEvents } from '@root/shared/AppEvents';

@Component({
  components: {
    ConfirmDialog,
    ProgressCircular
  }
})
class App extends Vue {
  private readonly timeout = 6000;
  private snackbar = false;
  private message: string|null = null;
  private color = 'error';
  private showProgress = false;

  created() {
    this.$root.$on(AppEvents.SHOW_ERROR, this.showError);
    this.$root.$on(AppEvents.SHOW_INFO, this.showInfo);
    this.$root.$on(AppEvents.SHOW_PROGRESS, this.showProgressCircular);
    this.$root.$on(AppEvents.HIDE_PROGRESS, this.hideProgressCircular);
  }

  private showError(message: string) {
    this.message = message;
    this.color = 'error';
    this.snackbar = true;
  }

  private showInfo(message: string) {
    this.message = message;
    this.color = 'success';
    this.snackbar = true;
  }

  private showProgressCircular() {
    this.showProgress = true;
  }

  private hideProgressCircular() {
    this.showProgress = false;
  }
}

export default App
</script>
