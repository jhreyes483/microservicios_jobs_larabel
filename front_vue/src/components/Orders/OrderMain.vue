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
                                <button @click="redirectToOrder(order.id)" class="btn btn-primary">Ver Detalles</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            isLoading: false
        }
    },
    methods: {
        getOrder() {
            this.isLoading= true;
            console.log('getOrders')
            updateServiceConfig(0, this.axios);

            this.axios.get('api/orders/', {}).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    this.orders = res.data.order;
                    console.log(this.orders)
                    this.isLoading = false;
                    /*
                    this.order = res.data.order;
                    this.recipe = res.data.order.recipe;
                    this.ingredients = res.data.order.recipe.ingredients;
                    this.status = res.data.order.status;
                    console.log("   this.order ", this.order)
                    console.log("   this.recipe ", this.recipe)
                    console.log("   status ", this.status)
                    */
                    /*
                  const url = `/order?id=${res.data.order_id}`;
                  Swal.fire({
                    icon: 'success',
                    text: res.data.msg,
                    footer: `<a href="${url}">Ver orden</a>`
                  });
                  */
                }
            }).catch(err => {
                this.isLoading= false;
                Swal.fire({
                    icon: 'error',
                    text: 'Error al registrar.',
                });
                console.error(err);
            });
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
