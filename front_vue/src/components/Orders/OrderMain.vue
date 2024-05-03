<template>

    <div class="container-fluid mt-4">
        <div>
            <h1>Ordenes</h1>

            <div v-if="isLoading" class="mt-5 spinner-border text-dark mt-4" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>


            <div v-else class="table-responsive col-md-8 mx-auto mt-4">
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
                            <td>
                                <span class="'badge badge-pill">
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
                                <button @click="redirectToOrder(order.id)" class="btn btn-success">Ver Detalles</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <button class ="btn btn-sm btn-light" @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Anterior</button>
                    {{ currentPage }}
                    <button class ="btn btn-sm btn-light"  @click="changePage(currentPage + 1)" :disabled="currentPage === lastPage">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import updateServiceConfig from '../../../config/services';
export default {

    name: 'OrderMain',
    data() {
        return {
            orders: {},
            isLoading: false,
            currentPage: 1
        }
    },
    methods: {
        getOrder() {
            this.isLoading = true;
            console.log('getOrders')
            updateServiceConfig(0, this.axios);

            let data = {
                page: this.currentPage
            }

            this.axios.post('api/get_orders/', { data }).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    this.orders = res.data.order.data;
                    console.log(this.orders)
                    this.isLoading = false;
                }
            }).catch(err => {
                this.isLoading = false;
                Swal.fire({
                    icon: 'error',
                    text: 'Error al registrar.',
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
        redirectToOrder(orderId) {
            this.$router.push({ name: 'OrderDetail', query: { id: orderId } });
        }


    },
    mounted() {
        this.getOrder();
    }

}
</script>
