<template>
  <v-dialog
    v-if="showDialog"
    v-model="system"
    light
    max-width="50vw"
    scrollable
    :persistent="true"
  >
    <v-card light>
      <v-toolbar
        light
        dense
        class="grey lighten-3"
      >
        <v-toolbar-title>
          {{ toolbarTitle }}
        </v-toolbar-title>
        <v-spacer />
        <v-btn
          icon
          light
          @click="showDialog = false"
        >
          <v-icon light>
            mdi-window-close
          </v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text class="pt-4">
        <v-form
          v-model="isValid"
        >
          <v-text-field
            v-model="system.name"
            :label="$t('system.name')"
            :rules="rules.get('name')"
            light
            dense
            class="pt-4"
          />
        </v-form>
      </v-card-text>
      <v-divider />
      <v-card-actions>
        <v-spacer />
        <v-btn
          color="primary"
          @click="save"
          :disabled="!isValid"
          >
          {{ $t('common.save') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Component, Mixins, Prop, PropSync } from 'vue-property-decorator';
import ValidationRules from '@root/mixins/ValidationRules';
import { AppEvents } from '@root/shared/AppEvents';
import { System } from './System';
import SystemClient from './SystemClient';

@Component
class SystemEdit extends Mixins(ValidationRules) {
  @PropSync('show', {type: Boolean, required: true}) showDialog!: boolean;
  @Prop() system!: System;

  private isValid = false;
  private rules!: Map<string, Function[]>;
  private apiClient!: SystemClient;

  created() {
    this.rules = new Map(
      [
        [
          'name',
          [
            (value: any) => this.isRequired(value),
            (value: any) => this.hasMaxLength(value, 100)
          ]
        ]
      ]
    );
    this.apiClient = new SystemClient();
  }

  get toolbarTitle() {
    return this.system.id ? this.$t('system.edit.updateTitle') : this.$t('system.edit.createTitle');
  }

  private save() {
    if (this.system.id) {
      this.update();
    } else {
      this.store();
    }
  }

  private update() {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.updateSystem(this.system)
      .then(() => {
        this.showDialog = false;
        this.$emit(AppEvents.NEED_REFRESH);
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      })
  }

  private store() {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.createSystem(this.system)
      .then(() => {
        this.showDialog = false;
        this.$emit(AppEvents.NEED_REFRESH);
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      })
  }
}

export default SystemEdit
</script>
