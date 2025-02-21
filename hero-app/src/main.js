import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

localStorage.removeItem('UserId');
createApp(App)
  .use(router)
  .mount('#app')
