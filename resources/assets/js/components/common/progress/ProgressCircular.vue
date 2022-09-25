<template>
  <v-container>
    <v-overlay z-index=1000>
      <v-progress-circular
        color="blue"
        indeterminate
        :size=64
      />
    </v-overlay>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
class ProgressCircular extends Vue {
}

export default ProgressCircular
</script>
