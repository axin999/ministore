<template>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item" id="navAdditems">
                <a class="nav-link" data-toggle="tab" href="#additems">Add Item</a>
            </li>
            <li class="nav-item" id="navAddCategory">
                <a class="nav-link" data-toggle="tab" href="#category">Add Category</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
