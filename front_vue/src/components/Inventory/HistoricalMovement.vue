<template>

<link href="https://solucionesintegralesmallorca.com/portafoliojav//public/css/fonts1.css" rel="stylesheet">
    <div class="container-fluid mt-4 col-md-9">
        <h2 >Historico movimientos warehouse</h2>
        <div>
            <div class="card card-body m-4">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="movementType">Tipo de Movimiento</label>
                        <select v-model="selectedMovementType" id="movementType" class="form-select">
                            <option selected value="0">Seleccione...</option>
                            <option v-for="type in movementTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="movementReason">Razón de Movimiento</label>
                        <select v-model="selectedMovementReason" id="movementReason" class="form-select">
                            <option selected value="0">Seleccione...</option>
                            <option v-for="reason in movementReasons" :key="reason.id" :value="reason.id">{{reason.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="movementIngredient">Ingredientes</label>
                        <select v-model="selectedIngredient" id="movementIngredient" class="form-select">
                            <option selected value="0">Seleccione...</option>
                            <option v-for="ingredient in movementIngredients" :key="ingredient.id"
                                :value="ingredient.id">{{
                                    ingredient.name }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 mt-4">
                        <label></label>
                        <button class="btn btm-alegra" @click="getMovements">Buscar <i class="fas fa-search"></i></button>
                    </div>

                </div>

            </div>

            <div v-if="isLoading" class="mt-5 spinner-border text-dark mt-4" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>


            <div v-else class="table-responsive mt-2">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cantidad</th>
                            <th>Ingrediente ID</th>
                            <th>Ingrediente</th>
                            <th>Motivo de Movimiento</th>
                            <th>Tipo de Movimiento</th>
                            <th>Usuario ID</th>
                            <th>Fecha de Creación</th>
                            <th>Fecha de Actualización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in movements" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ item.ingredient_id }}</td>
                            <td>{{ item.ingredient.name }}</td>
                            <td>{{ item.reazon.name }}</td>
                            <td>{{ item.type.name }}</td>
                            <td>{{ item.user_id }}</td>
                            <td>{{ formatDateTime(item.created_at) }}</td>
                            <td>{{ formatDateTime(item.updated_at) }}</td>
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

<style>



</style>

<script>
import Swal from 'sweetalert2';
import {updateServiceConfig} from '../../../config/services';
export default {
    name: "HistoricalMovements",
    data() {
        return {
            movements: {},
            isLoading: false,
            movementTypes: [],
            movementReasons: [],
            movementIngredients: [],
            selectedMovementType: 0,
            selectedMovementReason: 0,
            selectedIngredient: 0,
            currentPage: 1,
            lastPage: 1

        };
    },

    methods: {
        getMovements() {
            this.isLoading = true;
            console.log('getOrders')
            updateServiceConfig(1, this.axios);

            let postData = {
                movement_type_id: this.selectedMovementType,
                movement_reason_id: this.selectedMovementReason,
                movement_ingredient_id: this.selectedIngredient,
                page: this.currentPage
            };

            this.axios.post('api/get_ingredients/', postData).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    this.movements = res.data.movements.data;
                    this.lastPage  = res.data.movements.last_page 
                }
            }).catch(err => {
                this.isLoading = false;
                Swal.fire({
                    icon: 'error',
                    text: 'Error en petición..',
                });
                console.error(err);
            });
        },

        getComplements() {
            updateServiceConfig(1, this.axios);
            this.axios.post('api/get_complements/', {}).then(res => {
                if (res.data.status) {
                    console.log(res.data.data.ingredient)
                    this.movementTypes = res.data.data.types;
                    this.movementReasons = res.data.data.reasons;
                    this.movementIngredients = res.data.data.ingredient;
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
            this.getMovements()
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
    },
    mounted() {
        this.getComplements();
        this.getMovements();
    }

}
</script>