<template>
  <v-dialog
    v-if="showDialog"
    v-model="hardware"
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
            v-model="hardware.name"
            :label="$t('hardware.name')"
            :rules="rules.get('name')"
            light
            dense
            class="pt-4"
          />
          <v-text-field
            v-model="hardware.serialNumber"
            :label="$t('hardware.serialNumber')"
            :rules="rules.get('serialNumber')"
            light
            dense
            class="pt-4"
          />
          <v-autocomplete
            v-model="hardware.systemId"
            :items="systems"
            light
            dense
            chips
            small-chips
            deletable-chips
            item-text="name"
            item-value="id"
            :rules="rules.get('systemId')"
            :label="$t('hardware.system')"
            class="pt-4"
          />
          <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="true"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="hardware.productionMonth"
                light
                dense
                :label="$t('hardware.productionMonth')"
                prepend-icon="mdi-calendar"
                readonly
                :rules="rules.get('productionMonth')"
                v-bind="attrs"
                v-on="on"
                class="pt-4"
              />
            </template>
            <v-date-picker
              v-model="hardware.productionMonth"
              type="month"
            />
          </v-menu>
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
import { System } from '@component/system/System';
import ValidationRules from '@root/mixins/ValidationRules';
import { AppEvents } from '@root/shared/AppEvents';
import { Hardware } from './Hardware';
import HardwareClient from './HardwareClient';

@Component
class HardwareEdit extends Mixins(ValidationRules) {
  @PropSync('show', {type: Boolean, required: true}) showDialog!: boolean;
  @Prop() hardware!: Hardware;
  @Prop() systems!: System[];

  private isValid = false;
  private rules!: Map<string, Function[]>;
  private apiClient!: HardwareClient;
  private menu = false;

  created() {
    this.rules = new Map(
      [
        [
          'name',
          [
            (value: any) => this.isRequired(value),
            (value: any) => this.hasMaxLength(value, 100)
          ]
        ],
        [
          'serialNumber',
          [
            (value: any) => this.isRequired(value),
            (value: any) => this.hasMaxLength(value, 100)
          ]
        ],
        [
          'systemId',
          [
            (value: any) => this.isRequired(value)
          ]
        ],
        [
          'productionMonth',
          [
            (value: any) => this.isRequired(value)
          ]
        ]
      ]
    );
    this.apiClient = new HardwareClient();
  }

  get toolbarTitle() {
    return this.hardware.id ? this.$t('hardware.edit.updateTitle') : this.$t('hardware.edit.createTitle');
  }

  private save() {
    if (this.hardware.id) {
      this.update();
    } else {
      this.store();
    }
  }

  private update() {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.updateHardware(this.hardware)
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
    this.apiClient.createHardware(this.hardware)
      .then(() => {
        this.showDialog = false;
        this.$emit(AppEvents.NEED_REFRESH);
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      })
  }
}

export default HardwareEdit
</script>
