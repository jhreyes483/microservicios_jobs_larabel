<template>

    <div class="container-fluid mt-4">
        <h2>Cola de compras en espera</h2>

        <div class="col-md-2 mx-auto mt-5">
            <Lavel>Estado</Lavel>
            <select @change="getPurchases" v-model="selectedStatus" id="movementReason" class="form-select">
                <option selected value="0">Seleccione...</option>
                <option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.name }}</option>
            </select>
        </div>
        <div v-if="isLoading" class="mt-5 spinner-border text-dark mt-4" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <div v-else class="col-md-9 mx-auto">
            <div>
                <div>
                    <div class="table-responsive mt-5">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ingrediente</th>
                                    <th>Reintetos</th>
                                    <th>Estado</th>
                                    <th>Tipo</th>
                                    <th>Creación</th>
                                    <th>Actualización</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="purchase in purchases" :key="purchase.id">
                                    <td>{{ purchase.model_id }}</td>
                                    <td>{{ purchase.model.name }}</td>
                                    <td>{{ purchase.retry }}</td>
                                    <td :style="{ background: purchase.status.color }">{{ purchase.status.name }}</td>
                                    <td>{{ purchase.type.name }}</td>
                                    <td>{{ new Date(purchase.created_at).toLocaleString() }}</td>
                                    <td>{{ new Date(purchase.updated_at).toLocaleString() }}</td>
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
        </div>


    </div>

</template>

<script>
import Swal from 'sweetalert2';
import { updateServiceConfig } from '../../../config/services';
export default {
    name: "HistoricalPurchase",
    data() {
        return {
            purchases: {},
            isLoading: false,
            currentPage: 1,
            lastPage: 1,
            selectedStatus: 0,
            statuses: {}
        };
    },
    mounted() {
        this.getPurchases()
        this.getStatuses()
        this.interval = setInterval(() => {
            window.location.reload();
        }, 60000);
    },
    methods: {
        getPurchases() {
            this.isLoading = true;
            updateServiceConfig(1, this.axios);
            let data = {
                page: this.currentPage,
                status_id: this.selectedStatus
            }

            this.axios.post('api/get_purchase/', data).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    this.purchases = res.data.purchases.data;
                    this.lastPage = res.data.purchases.last_page;
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
        changePage(page) {
            console.log("page", page);
            this.currentPage = page;
            this.getPurchases()
        },
    }

}
</script>