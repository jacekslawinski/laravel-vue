<template>
  <v-dialog
    v-if="showDialog"
    v-model="user"
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
            v-model="user.firstname"
            :label="$t('user.firstname')"
            :rules="rules.get('firstname')"
            light
            dense
            class="pt-4"
          />
          <v-text-field
            v-model="user.lastname"
            :label="$t('user.lastname')"
            :rules="rules.get('lastname')"
            light
            dense
            class="pt-4"
          />
          <v-text-field
            v-model="user.email"
            :label="$t('user.email')"
            :rules="rules.get('email')"
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
import { User } from './User';
import UserClient from './UserClient';

@Component
class UserEdit extends Mixins(ValidationRules) {
  @PropSync('show', {type: Boolean, required: true}) showDialog!: boolean;
  @Prop() user!: User;

  private isValid = false;
  private rules!: Map<string, Function[]>;
  private apiClient!: UserClient;

  created() {
    this.rules = new Map(
      [
        [
          'firstname',
          [
            (value: any) => this.isRequired(value),
            (value: any) => this.hasMaxLength(value, 50)
          ]
        ],
        [
          'lastname',
          [
            (value: any) => this.isRequired(value),
            (value: any) => this.hasMaxLength(value, 50)
          ]
        ],
        [
          'email',
          [
            (value: any) => this.isRequired(value),
            (value: any) => this.isEmail(value)
          ]
        ]
      ]
    );
    this.apiClient = new UserClient();
  }

  get toolbarTitle() {
    return this.user.id ? this.$t('user.edit.updateTitle') : this.$t('user.edit.createTitle');
  }

  private save() {
    if (this.user.id) {
      this.update();
    } else {
      this.store();
    }
  }

  private update() {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.updateUser(this.user)
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
    this.apiClient.createUser(this.user)
      .then(() => {
        this.showDialog = false;
        this.$emit(AppEvents.NEED_REFRESH);
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      })
  }
}

export default UserEdit
</script>
