<template lang="">
    <div>
        <div class="w-full flex justify-center items-center h-screen">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" enctype="multipart/form-data" ref="uploadForm">
                <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                 v-model="title" id="title" name="title" type="text" placeholder="Title">
                </div>
                <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                v-model="description" id="description" name="description"/>
                </div>
                <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Document
                </label>
                <input type="file" @change="onFileChange">                              
                </div>
                <div class="flex items-center justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="uploadDocument">
                    Upload
                </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title:'',
            description:'',
            documentFile:null,
            userId:1,
            success:null
        }
    },
    methods: {
        onFileChange(event){
            this.documentFile = event.target.files[0];
        },
        uploadDocument(){
            let currentObj = this;

            const config = {
                headers: {
                'content-type': 'multipart/form-data',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }
            let formData = new FormData();
            formData.append('title', this.title);
            formData.append('description', this.description);
            formData.append('user_id', this.userId);
            formData.append('document_file', this.documentFile);
            
            axios.post('/api/v1/documents', formData, config)
            .then(function (response) {
                this.success = response.data.success;
                currentObj.$refs.uploadForm.reset();
            })
            .catch(function (error) {
                console.log(error.response.data);
            });
        },
    },
}
</script>