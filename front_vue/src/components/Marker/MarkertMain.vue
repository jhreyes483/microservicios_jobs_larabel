<template>
    <div class="container-fluid mt-4 col-md-9">
        <h4>Plaza de productos</h4>


        <div v-if="isLoading" class="mt-5 spinner-border text-dark mt-4" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <div v-else>
            <div class="table-responsive mt-2 col-md-11 mx-auto">
                <button type="submit" @click="submitQuantities()" class="m-3 btn btm-alegra btn-sm">Actualizar</button>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ingrediente</th>
                            <th>Cantidad</th>
                            <th>Creacion</th>
                            <th>Actualización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ingredient in ingredients" :key="ingredient.id">
                            <td>{{ ingredient.id }}</td>
                            <td>{{ ingredient.name }}</td>
                            <td>
                                <input type="number" v-model.number="ingredient.quantity"
                                    class="narrow-input mx-auto form-control form-control-sm" min="0">
                            </td>
                            <td>{{ new Date(ingredient.created_at).toLocaleString() }}</td>
                            <td>{{ new Date(ingredient.updated_at).toLocaleString() }}</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <button class="btn btn-sm btn-light" @click="changePage(currentPage - 1)"
                        :disabled="currentPage === 1">Anterior</button>
                    {{ currentPage }}
                    <button class="btn btn-sm btn-light" @click="changePage(currentPage + 1)"
                        :disabled="currentPage === lastPage">Siguiente</button>
                </div>
            </div>
        </div>


    </div>


</template>
<script>
import Swal from 'sweetalert2';
import updateServiceConfig from '../../../config/services';
export default {
    name: 'MarkertMain',
    data() {
        return {
            ingredients: {},
            isLoading: false,
            currentPage: 1,
            lastPage: 1,
        }
    },
    methods: {
        getMarket() {
            this.isLoading = true;

            updateServiceConfig(2, this.axios);
            this.axios.post('api/farmers-market/get', {}).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    this.ingredients = res.data.ingredients.data;
                    this.lastPage = res.data.ingredients.last_page
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
        submitQuantities() {
            this.isLoading = true;
            updateServiceConfig(2, this.axios);

            let update = this.ingredients.map(({ id, quantity }) => ({ id, quantity }));
            this.axios.post('api/farmers-market/update', { update }).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    console.log(res.data);
                    this.getMarket();
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
            this.getMovements()
        },
    },

    mounted() {
        this.getMarket();
    }

}
</script>

<style>
.narrow-input {
    width: 100px;
}

.btm-alegra {
    background-color: #30aba9 !important;
    color: #ffff;
}


.btm-alegra:hover {
    background-color: #248886 !important;
    color: #ffff;
}
</style>