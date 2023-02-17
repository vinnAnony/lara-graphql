<template lang="">
    <div>
        <div class="flex flex-col justify-center items-center h-screen">
            <h1 class="text-3xl text-purple-600 font-bold">Welcome</h1>
            <router-link to="/graphql-upload">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-2 rounded focus:outline-none focus:shadow-outline">
                    GraphQL Upload Document
                </button>
            </router-link>
            
        </div>
    </div>
</template>
<script>
export default {
    
}
</script>
<style lang="">
    
</style>