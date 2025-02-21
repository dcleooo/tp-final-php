import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/homePage.vue';
import Login from '../pages/loginPage.vue';
import HeroDetail from '../pages/heroDetail.vue';

const routes = [
  { path: '/', component: Login },
  { path: '/home', component: Home },
  { path: '/hero/:HeroId', component: HeroDetail, props: true },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
