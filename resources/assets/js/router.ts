import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import UserList from '@component/user/UserList.vue';
import HardwareList from '@component/hardware/HardwareList.vue';
import SystemList from '@component/system/SystemList.vue';

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: '/',
    redirect: to => {
      return { name: 'UserList'}
    }
  },
  {
    path: '/user',
    name: 'UserList',
    component: UserList
  },
  {
    path: '/hardware',
    name: 'HardwareList',
    component: HardwareList
  },
  {
    path: '/system',
    name: 'SystemList',
    component: SystemList
  }
]

const router = new VueRouter({
  routes,
  mode: 'history'
});

export default router
