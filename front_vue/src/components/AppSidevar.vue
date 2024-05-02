<template>
    <div class="col-md-3">
        <div class="">
            <form>
                <div class="card body-with-card bg-light float-end">
                    <div class="card-body ">
                        <b class="font-3">PUEDES HACER ESTO</b>
                        <hr>
                        Encuentra el articulo que buscas
                        <div class="text-center">
                            <input type="submit" value="CREAR ARTÍICULO" class="col-2 form-control mt-3 btn-success">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="">
            <form>
                <div class="card body-with-card bg-light float-end">
                    <div class="card-body ">
                        <b class="font-3">BUSCADOR</b>
                        <hr>
                        Encuentra el articulo que buscas
                        <input type="text" class="form-control">

                        <div class="text-center">
                            <input type="submit" value="BUSCAR" class="col-2 form-control btn-dark  mt-3">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: 'AppSidevar'
}
</script>