<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link :to="{ name: 'TeamIndex' }"  class="nav-item nav-link">Teams</router-link> 
                    <router-link :to="{ name: 'Simulation' }"  class="nav-item nav-link">Simulation</router-link>
                </div>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>

<script>
    export default {}
</script>