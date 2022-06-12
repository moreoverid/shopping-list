<template>
    <div>
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <img class="me-3" src="/img/bootstrap-logo-white.svg" alt="" width="48" height="38">
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1 fw-bold">Shopping List Web App</h1>
                <small>Powered by Laravel, Bootstrap and Vue.js</small>
            </div>
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <div class="border-bottom pb-2 mb-0 row">
                <div class="col-sm-4">
                    <input class="form-control d-inline-block flow-right"
                           id="name"
                           type="text"
                           placeholder=""
                           v-model="form.name"
                    >
                    <div id="name" class="form-text">What are you going to buy?</div>
                </div>

                <div class="col-sm-3">
                    <input class="form-control d-inline-block flow-right"
                           id="quantity"
                           type="text"
                           placeholder=""
                           v-model="form.quantity"
                    >
                    <div id="quantity" class="form-text">Quantity</div>
                </div>

                <div class="col-sm-3">
                    <input class="form-control d-inline-block flow-right"
                           id="price"
                           type="text"
                           placeholder=""
                           v-model="form.price"
                    >
                    <div id="price" class="form-text">Price</div>
                </div>

                <div class="col-sm-2 text-center">
                    <div class="d-inline-block">
                        <button type="button"
                                class="btn btn-sm btn-outline-success d-inline-block"
                                @click="createUpdateItem()"
                        >
                            {{ form.id === null ? 'Add' : 'Update' }}
                        </button>
                    </div>

                    <div class="ml-1 d-inline-block">
                        <button type="button"
                                class="btn btn-sm btn-outline-secondary "
                                @click="resetForm()"
                        >
                            Clear
                        </button>
                    </div>
                </div>
            </div>

            <table class="custom-table">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Action</th>
                </tr>

                <tr :key="item.id" v-for="(item, index) in items">
                    <td class="text-center td-w35px">
                        <svg class="bd-placeholder-img rounded d-block"
                             width="32"
                             height="32"
                             xmlns="http://www.w3.org/2000/svg"
                             role="img"
                             aria-label="Placeholder: 32x32"
                             preserveAspectRatio="xMidYMid slice"
                             focusable="false">
                            <title>Placeholder</title><rect width="100%" height="100%" :fill="getRandomColour(index)"/>
                            <text x="50%" y="50%" fill="#ffffff" dy=".3em">{{ index + 1 }}</text>
                        </svg>
                    </td>
                    <td><a @click="editItem(item)" href="javascript:void(0);">{{ `${item.name}` }}</a></td>
                    <td class="td-mw80px text-center">{{ item.quantity }}</td>
                    <td class="td-mw80px text-center">{{ item.price }}</td>
                    <td class="td-mw80px text-center"><a href="javascript:void(0);" @click="removeItem(item.id)">remove</a></td>
                </tr>
            </table>

            <small class="d-block text-end mt-3">
                <a href="javascript:void(0);" @click="removeAll()">Clean all</a>
            </small>
        </div>

    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import { useToast } from "vue-toastification";

const API_SHOPPING_LIST = '/api/v1/shopping-list';

const toast = useToast();
const isLoading = ref(false);
const items = ref([]);
const pagination = ref(null);

const form = ref({});

// Clean form from created or edited data
function resetForm()
{
    form.value = {
        id: null,
        name: '',
        quantity: null,
        price: null,
    };
}

// Get data form backend
function fetch() {
    isLoading.value = true;

    axios.get(API_SHOPPING_LIST, {}).then((res) => {
        items.value = res.data.data;
        pagination.value = res.data.meta;
    }, (err) => {
        //
    }).finally(() => {
        isLoading.value = false;
    })
}

// Create new record
function createUpdateItem() {
    let method = form.value.id === null ? 'post' : 'put';
    let url = form.value.id === null ? API_SHOPPING_LIST : `${API_SHOPPING_LIST}/${form.value.id}`

    return axios[method](url, form.value)
        .then((res) => {
            resetForm();
            fetch();
            toast.success("Item created!", {
                timeout: 5000
            });
        }, (err) => {
            showError(err);
    }).finally(() => {
        isLoading.value = false;
    })
}

// Edit existing record
function editItem(row) {
    form.value = row;
}

// Remove chosen record
function removeItem(id) {
    return axios.delete(`${API_SHOPPING_LIST}/${id}`)
        .then((res) => {
            fetch();
            toast.success("Item removed!", {
                timeout: 5000
            });
        }, (err) => {
            showError(err);
        }).finally(() => {
            isLoading.value = false;
        })
}

// Remove all
function removeAll() {
    return axios.delete(`${API_SHOPPING_LIST}/remove-all`)
        .then((res) => {
            fetch();
            toast.success("All items removed!", {
                timeout: 5000
            });
        }, (err) => {
            showError(err);
        }).finally(() => {
            isLoading.value = false;
        })
}

// Compute colour based on item index number
function getRandomColour(index) {
    if ((index + 1) % 2 === 0) {
        return '#e83e8c';
    }
    if ((index + 1) % 3 === 0) {
        return '#6f42c1';
    }

    return '#007bff';
}

// Get error from backend response and show it ia toast plugin
function showError(err) {
    if (err.response && err.response.data.errors) {
        const eList = err.response.data.errors;
        for (let key in eList) {
            toast.error(`${eList[key].pop()}`, {
                timeout: 5000
            });
        }
        return
    }
    toast.error(err.message, {
        timeout: 5000
    });
}

onMounted(() => {
    resetForm();
    fetch();
})

</script>

<style scoped>
.td-mw150px {
    min-width: 150px;
}
.td-mw80px {
    min-width: 80px;
}
.td-w35px {
    width: 35px;
}
</style>
