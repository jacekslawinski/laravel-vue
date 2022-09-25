
import { _ } from '@root/main';
import { TranslateResult } from 'vue-i18n';

export interface ConfirmInterface {
  title: TranslateResult;
  message: TranslateResult;
  confirmText: TranslateResult|null;
  cancelText: TranslateResult|null;
  confirmAction: Function|null;
  data: any;
}

export class Confirm implements ConfirmInterface {
  title: TranslateResult;
  message: TranslateResult;
  confirmText: TranslateResult|null;
  cancelText: TranslateResult|null;
  confirmAction: Function|null;
  data: any;

  constructor(confirm: Partial<ConfirmInterface>) {
    this.title = _.get(confirm, 'title', '');
    this.message = _.get(confirm, 'message', '');
    this.confirmText = _.get(confirm, 'confirmText', null);
    this.cancelText = _.get(confirm, 'cancelText', null);
    this.confirmAction = _.get(confirm, 'confirmAction', null);
    this.data = confirm.data;
  }
}
