import { TranslateResult } from 'vue-i18n';
import { DataTableHeader } from 'vuetify';

export default interface AppDataTableHeader extends Omit<DataTableHeader, 'text'> {
  text: TranslateResult;
}
