<template>
    <div id="carouselExampleIndicators" class="carousel slide container mt-4 slider" data-bs-ride="carousel">
       <h1> {{ texto }}</h1>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://th.bing.com/th/id/R.92319095e402c9033030a83d0c89136b?rik=rcblIR1C6WeyAQ&riu=http%3a%2f%2fwww.villapalmarcancun.com.mx%2fblog%2fwp-content%2fuploads%2f2016%2f11%2fperfect-plate-at-the-perfect-restaurant.jpg&ehk=7%2fMX6AdBOBebpxs%2b95l9ToYNBVC0wLpiPrGp%2fCxYR2E%3d&risl=&pid=ImgRaw&r=0"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/R.3f97d129a657229807069b61e02fdd25?rik=XS%2b58lX7OMLgnQ&pid=ImgRaw&r=0" class="d-block w-100"
                    alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://i.pinimg.com/originals/5f/16/f3/5f16f374385998d6ce2944a7bcac5bbe.jpg" class="d-block w-100"
                    alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        

    </div>
<!-- 
    <route-link v-if="showBtn" to="/blog" class="btn btn-sm btn-success mt-1">Blog</route-link>
     -->
</template>

<script>
export default {
    name: 'AppSlider',
    props: ['texto', 'showBtn']



}
</script>