<template>
    <div class="container-fluid">
        <div>

            <div v-if="isLoading" class="mt-5 spinner-border text-dark mt-4" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>

            <div  v-else class="row container-fluid col-md-9 mx-auto mt-5">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 >Id de orden: {{ order.id }} </h2>
                            <div class="card">

                                <div class="card mb-1 " :style="{ background: status.color }">
                                    <h3>Estado: {{ status.name }} </h3>
                                </div>
                               
                                <p> Creación: {{ formatDateTime(order.created_at) }} </p>
                                <p> Acutalización: {{ formatDateTime(order.created_at) }} </p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h2>{{ recipe.name }}</h2>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Ingrediente</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ingredient in recipe.ingredients" :key="ingredient.id">
                                            <td>{{ ingredient.id }}</td>
                                            <td>{{ ingredient.name }}</td>
                                            <td>{{ ingredient.pivot.recipe_quantity }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2';
import updateServiceConfig from '../../../config/services';

export default {
     name: 'OrderDeital',
    data() {
        return {
            order: {},
            recipe: {},
            ingredients: {},
            status: {},
            order_id: 0,
            selectedOption: '', // Almacena la opción seleccionada
            isLoading: false
        };
    },
    methods: {
        getOrder() {
            this.isLoading = true;
            console.log("aca");
            updateServiceConfig(0, this.axios);
            this.order_id = this.$route.query.id;
            this.axios.get('api/orders/' + this.order_id, {}).then(res => {
                if (res.data.status) {
                    this.isLoading= false;
                    console.log(res.data)
                    this.order = res.data.order;
                    this.recipe = res.data.order.recipe;
                    this.ingredients = res.data.order.recipe.ingredients;
                    this.status = res.data.order.status;
                    console.log("   this.order ", this.order)
                    console.log("   this.recipe ", this.recipe)
                    console.log("   status ", this.status)
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
        }


    },
    mounted() {
        this.getOrder();
    }
}
</script>
