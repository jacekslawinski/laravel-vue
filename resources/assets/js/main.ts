import Vue from 'vue';
import Vuetify from 'vuetify';
import VueLodash from 'vue-lodash';
import VueI18n from 'vue-i18n';
// @ts-ignore
import pl from 'vuetify/lib/locale/pl';
import _ from 'lodash';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
import App from './App.vue';
import { defaultLocale, messages } from '@root/i18n';
import router from './router';

Vue.use(Vuetify);
Vue.use(VueLodash, {lodash: _});
Vue.use(VueI18n);

export const i18n = new VueI18n({
  messages: messages,
  locale: defaultLocale,
  fallbackLocale: defaultLocale,
  silentFallbackWarn: true
});

const VueInstance = new Vue({
  el: '#app',
  render: (h: any) => h(App),
  vuetify: new Vuetify({
    icons: {
      iconfont: 'mdiSvg'
    },
    lang: {
      locales: { pl },
      current: 'pl'
    }
  }),
  router,
  i18n
});

export { _, VueInstance }
