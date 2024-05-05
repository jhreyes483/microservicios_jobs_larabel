<template>
    <div class="container-fluid mt-4">
        <h2>Ordenes</h2>
        <div>
            <div class="col-md-2 col-4 mx-auto mt-5">
                <Lavel>Estado</Lavel>
                <select @change="getOrder" v-model="selectedStatus" id="movementStatus" class="form-select"
                   >
                   <option selected value="0">Seleccione...</option>
                    <option v-for="status in statuses" :key="status.id" :value="status.id">{{
                        status.name }}</option>
                </select>
            </div>

            <div v-if="isLoading" class="mt-5 spinner-border text-dark mt-4" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>


            <div v-else class="table-responsive col-md-10 mx-auto mt-5">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Creación</th>
                            <th>Estado</th>
                            <th>Receta</th>
                            <th>Ingredientes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id">
                            <td>{{ order.id }}</td>
                            <td>{{ formatDateTime(order.created_at) }}</td>
                            <td :style="{ background: order.status.color }">
                                <span>
                                    {{ order.status.name }}
                                </span>
                            </td>
                            <td>{{ order.recipe.name }}</td>
                            <td>
                                <ul>
                                    <li v-for="ingredient in order.recipe.ingredients" :key="ingredient.id">
                                        {{ ingredient.name }} ({{ ingredient.pivot.recipe_quantity }})
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <button @click="redirectToOrder(order.id)" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i> 
                                  </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <button class="btn btn-sm btn-light" @click="changePage(currentPage - 1)"
                        :disabled="currentPage === 1">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    {{ currentPage }}
                    <button class="btn btn-sm btn-light" @click="changePage(currentPage + 1)"
                        :disabled="currentPage === lastPage">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import {updateServiceConfig } from '../../../config/services';
export default {

    name: 'OrderMain',
    data() {
        return {
            orders: {},
            isLoading: false,
            currentPage: 1,
            lastPage: 1,
            selectedStatus: 0,
            statuses: {}
        }
    },
    methods: {
        getOrder() {
            this.isLoading = true;
            updateServiceConfig(0, this.axios);

            let data = {
                page: this.currentPage,
                status_id: this.selectedStatus
            }

            this.axios.post('api/get_orders/',  data ).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    this.orders = res.data.order.data;
                    this.lastPage = res.data.order.last_page;
                    console.log(this.orders)
                }
            }).catch(err => {
                this.isLoading = false;
                Swal.fire({
                    icon: 'error',
                    text: 'Error en petición.',
                });
                console.error(err);
            });
        },
        changePage(page) {
            console.log("page", page);
            this.currentPage = page;
            this.getOrder()
        },
        formatDateTime(dateTimeString) {
            const options = {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "numeric",
                minute: "numeric",
                second: "numeric",
                timeZoneName: "short"
            };
            const dateTime = new Date(dateTimeString);
            return dateTime.toLocaleString("es-ES", options);
        },
        getStatuses() {
            updateServiceConfig(0, this.axios);
            let data = {
                status_ids: [4, 7]
            }
            this.axios.post('api/get_status', data).then(res => {
                this.statuses = res.data.statuses;
            }).catch(err => {
                Swal.fire({
                    icon: 'error',
                    text: 'Error en petición.',
                });
                console.error(err);
            });
        },
        redirectToOrder(orderId) {
            this.$router.push({ name: 'OrderDetail', query: { id: orderId } });
        }


    },
    mounted() {
        this.getOrder();
        this.getStatuses()
    }

}
</script>
