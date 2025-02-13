import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import Toast from 'vue-toastification';
import '@fortawesome/fontawesome-free/css/all.css';
import 'vue-toastification/dist/index.css';

const toastOptions = {
    position: 'top-right',
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
};

const app = createApp(App);
app.use(router);
app.use(Toast, toastOptions);
app.mount('#app');
