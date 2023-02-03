<template lang="">
    <div>
        <div class="w-full flex flex-col justify-center items-center h-screen">
            <div class="bg-green-100 p-2 mt-2 mb-2 rounded" v-show="success">
                Successfully uploaded! <a :href="uploadUrl" target="_blank">Click to view</a>
            </div>
            <div class="bg-red-100 p-2 mt-2 mb-2 rounded" v-show="responseHasError">
                <p class="text-red-500 text-xs italic" v-for="error in responseErrors" :key="error.index">
                    {{error}}
                </p> 
            </div>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
             enctype="multipart/form-data" ref="uploadForm" @submit="uploadDocument">
                <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                 v-model="title" id="title" name="title" type="text" placeholder="Title" required>
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
                <input type="file" @change="onFileChange" required>                            
                </div>
                <div class="flex items-center justify-center">
                    <input type="submit" class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer"
                    :value="getUploadButtonText"
                    :disabled="isUploading"
                    :class="{'bg-blue-200 cursor-not-allowed': isUploading,'bg-blue-500 hover:bg-blue-700': !isUploading}">                
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title: '',
            description: '',
            documentFile: null,
            userId: 1,
            success: null,
            isUploading:false,
            uploadUrl: null,
            responseHasError: false,
            responseErrors:[],
        }
    },
    methods: {
        onFileChange(event) {
            this.documentFile = event.target.files[0];
        },
        uploadDocument(e) {
            e.preventDefault();

            this.isUploading = true;
            this.clearResponseErrors();

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }            

            let formData = new FormData();
            formData.set('operations', JSON.stringify({
                // Mutation string
                'query': `mutation addDocument($title:String!,$description:String!,$userId:Int!,$documentFile: Upload!) {
                        CreateDocument  (,title:$title,description:$description,user_id:$userId,document_file: $documentFile){id title url}
                      }`,
                'variables': { "title": this.title, "description": this.description, "userId": this.userId, "documentFile": this.documentFile }
            }));
            formData.set('operationName', null);
            formData.set('map', JSON.stringify({ "document_file": ["variables.documentFile"] }));

            formData.append('title', this.title);
            formData.append('description', this.description);
            formData.append('user_id', this.userId);
            formData.append('document_file', this.documentFile);

            axios.post('/api/v2', formData, config)
                .then((response) => {
                    this.isUploading = false;
                                                          
                    if (response.data.errors) {
                        this.responseHasError = true;
                        let errors = response.data.errors[0].extensions.validation;
                        let errorMessages=[];
                        Object.keys(errors).forEach((key) => {
                            errors[key].map((errorMessage) => {
                                errorMessages.push(errorMessage);
                                this.responseErrors = errorMessages;
                            })
                        }) 
                    } else if (response.data.data.CreateDocument) {
                        this.success = true;
                        this.uploadUrl = response.data.data.CreateDocument.url;

                        this.resetFormInput();
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        clearResponseErrors() {
            this.responseHasError = false;
            this.responseErrors = [];
        },
        resetFormInput() {
            this.title = '';
            this.description = '';
            this.documentFile = null;
        }
    },
    computed: {
        getUploadButtonText() {
            return this.isUploading ? 'Uploading...' : 'Upload';
        }
    },
}
</script>