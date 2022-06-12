import { createApp } from 'vue'
const app = createApp({})

// Enable Toast plugin
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
const options = {
    // You can set your default options here
};
app.use(Toast, options);

// Components list
app.component('Index', require('./components/Index').default)

// Mount to tag id="app"
app.mount('#app')
