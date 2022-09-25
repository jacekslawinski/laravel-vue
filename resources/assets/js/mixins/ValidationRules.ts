import { Component, Vue } from 'vue-property-decorator';

@Component
class ValidationRules extends Vue {

  isRequired(value: any) {
    return !this.isEmpty(value) || this.$t('validation.isRequired');
  }

  isEmail(value: string) {
    if (this.isEmpty(value)) {
      return true;
    }
    const regex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,4})+$/;
    return regex.test(value) || this.$t('validation.isEmail');
  }

  hasMaxLength(value: any, maxLen: number) {
    if (this.isEmpty(value)) {
      return true;
    }
    return value.toString().length <= maxLen || this.$t('validation.hasMaxLength', {maxLength: maxLen});
  }

  isEmpty(value: any) {
    return value === undefined ||
      value === null ||
      !value.toString().replace(/\s/g, '') ||
      (Array.isArray(value) && !value.length);
  }
}

export default ValidationRules
