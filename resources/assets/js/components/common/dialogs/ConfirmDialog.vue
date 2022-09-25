<template>
  <v-dialog
    v-model="showDialog"
    light
    :persistent="true"
    width="auto"
    max-width="50vw"
    :fullscreen="$vuetify.breakpoint.xsOnly"
  >
    <v-card
      light
    >
      <v-toolbar
        light
        dense
        class="grey lighten-3"
      >
        <v-toolbar-title>
          {{ confirm.title }}
        </v-toolbar-title>
      </v-toolbar>
      <v-card-text class="pt-4">
        {{ confirm.message }}
      </v-card-text>
      <v-divider class="my-0" />
      <v-card-actions>
        <v-spacer />
        <v-btn
          v-if="confirm.cancelText"
          light
          @click="onCancel"
        >
          {{ confirm.cancelText }}
        </v-btn>
        <v-btn
          v-if="confirm.confirmText"
          light
          @click="onConfirm"
        >
          {{ confirm.confirmText }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { AppEvents } from '@root/shared/AppEvents';
import { Confirm } from './Confirm';

@Component
class ConfirmDialog extends Vue {
  private showDialog = false;
  private confirm = new Confirm({});

  mounted() {
    this.$root.$on(AppEvents.SHOW_CONFIRM, this.showConfirmDialog);
  }

  showConfirmDialog(confirm: Confirm) {
    this.confirm = confirm;
    this.showDialog = true;
  }

  private onCancel() {
    this.showDialog = false;
  }

  private onConfirm() {
    if (this._.isFunction(this.confirm.confirmAction)) {
      this.confirm.confirmAction(this.confirm.data);
    }
    this.showDialog = false;
  }
}

export default ConfirmDialog
</script>
