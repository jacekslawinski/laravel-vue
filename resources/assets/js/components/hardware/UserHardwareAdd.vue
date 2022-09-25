<template>
  <v-dialog
    v-model="showDialog"
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
          {{ $t('hardware.toUserTitle') }}
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
          <v-autocomplete
            v-model="user"
            :items="users"
            light
            dense
            chips
            small-chips
            deletable-chips
            :item-text="getFullname"
            item-value="id"
            :rules="rules.get('user')"
            :label="$t('hardware.user')"
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
import { User, UserInterface } from '../user/User';
import { Component, Mixins, Prop, PropSync } from 'vue-property-decorator';
import UserClient from '@component/user/UserClient';
import ValidationRules from '@root/mixins/ValidationRules';
import { AppEvents } from '@root/shared/AppEvents';
import { Hardware } from './Hardware';
import HardwareClient from './HardwareClient';

@Component
class UserHardwareAdd extends Mixins(ValidationRules) {
  @PropSync('show', {type: Boolean, required: true}) showDialog!: boolean;
  @Prop({required: true}) hardware!: Hardware;

  private isValid = false;
  private rules!: Map<string, Function[]>;
  private apiClient!: HardwareClient;
  private userApiClient!: UserClient;
  private users: User[] = [];
  private user: number|null = null;

  created() {
    this.rules = new Map(
      [
        [
          'user',
          [
            (value: any) => this.isRequired(value)
          ]
        ]
      ]
    );
    this.apiClient = new HardwareClient();
    this.userApiClient = new UserClient();
    this.getUsers();
  }

  private getUsers() {
    this.users = [];
    this.userApiClient.getUsers()
      .then((data: any) => {
        data.result.forEach((user: UserInterface) => {
          this.users.push(new User(user));
        })
      });
  }

  private getFullname(user: User) {
    return user.getFullname();
  }

  private save() {
    this.$root.$emit(AppEvents.SHOW_PROGRESS);
    this.apiClient.addUserHardware(this.hardware, this.user!)
      .then(() => {
        this.$emit(AppEvents.NEED_REFRESH);
        this.showDialog = false;
      })
      .finally(() => {
        this.$root.$emit(AppEvents.HIDE_PROGRESS);
      });
  }
}

export default UserHardwareAdd
</script>
