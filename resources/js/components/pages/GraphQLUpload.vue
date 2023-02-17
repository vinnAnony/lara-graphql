<template lang="">
    <div>
        <div class="w-full flex flex-col justify-center items-center h-screen">
            <div class="bg-green-100 p-2 mt-2 mb-2 rounded" v-show="success">
                <p>Successfully uploaded! <a :href="uploadUrl" target="_blank"><strong><u>Click to view</u></strong></a></p>
                <p>Link will disappear in 15 seconds.</p>
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
                    <p v-if="validationErrMsg.title" class="text-red-500 text-xs italic">
                        {{validationErrMsg.title[0]}}
                    </p> 
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    v-model="description" id="description" name="description"/>
                    <p v-if="validationErrMsg.description" class="text-red-500 text-xs italic">
                        {{validationErrMsg.description[0]}}
                    </p> 
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Document
                    </label>
                    <input type="file" @change="onFileChange" required>                            
                    <p v-if="validationErrMsg.doc_file" class="text-red-500 text-xs italic">
                        {{validationErrMsg.doc_file[0]}}
                    </p> 
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Upload to
                    </label>
                    <div class="flex flex-row space-x-4">
                        <div class="flex flex-row space-x-2">
                            <input type="checkbox" v-model="uploadLocal" name="upload_local">
                            <div>                                
                                Local Storage
                            </div> 
                        </div>
                        <div class="flex flex-row space-x-2">
                            <input type="checkbox" v-model="uploadAws" name="upload_aws">
                            <div>                                
                                AWS
                            </div> 
                        </div>
                    </div>
                    <p v-if="validationErrMsg.upload_to" class="text-red-500 text-xs italic">
                        {{validationErrMsg.upload_to}}
                    </p>                     
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
import validationMixin from "../../mixin/validationMixin";
export default {
    mixins: [
        validationMixin
    ],
    data() {
        return {
            title: '',
            description: '',
            documentFile: null,
            userId: 1,
            uploadLocal:null,
            uploadAws:null,
            success: null,
            isUploading:false,
            uploadUrl: null,
            responseHasError: false,
            responseErrors: [],
        }
    },
    methods: {
        onFileChange(event) {
            let fileName = event.target.files[0].name;
            let fileExtension = fileName.substr(fileName.lastIndexOf("."));
            let fileSize = event.target.files[0].size;

            if (this.validateDocumentFile(fileExtension,fileSize)) {
                this.documentFile = event.target.files[0];
            }
            
        },
        uploadDocument(e) {
            e.preventDefault();

            this.isUploading = true;
            this.clearResponseErrors();

            this.validateUploadLocation()
            
            if (Object.keys(this.validationErrMsg).length > 0) {
                this.isUploading = false;
                return;
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }            

            let formData = new FormData();
            formData.set('operations', JSON.stringify({
                // Mutation string
                'query': `mutation addDocument($title:String!,$description:String!,$userId:Int!,$documentFile: Upload!,$uploadLocal: Boolean,$uploadAws: Boolean) {
                        CreateDocument  (title:$title,description:$description,user_id:$userId,document_file: $documentFile,upload_local: $uploadLocal,upload_aws: $uploadAws)
                        {id title url}
                      }`,
                'variables': {
                    "title": this.title,
                    "description": this.description,
                    "userId": this.userId,
                    "documentFile": this.documentFile,
                    "uploadLocal": this.uploadLocal,
                    "uploadAws": this.uploadAws
                }
            }));
            formData.set('operationName', null);
            formData.set('map', JSON.stringify({ "document_file": ["variables.documentFile"] }));

            formData.append('title', this.title);
            formData.append('description', this.description);
            formData.append('user_id', this.userId);
            formData.append('upload_local', this.uploadLocal);
            formData.append('upload_aws', this.uploadAws);
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
                        setTimeout(() => {
                            this.success = false; 
                        }, 15000);

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
            this.$refs.uploadForm.reset();
            this.title = '';
            this.description = '';
            this.documentFile = null;
            this.uploadLocal = null;
            this.uploadAws = null;
        },
        validateUploadLocation(){
            if (!this.uploadLocal && !this.uploadAws) {
                this.validationErrMsg.upload_to = "Select at least one location to upload to.";                
            }
        }
    },
    computed: {
        getUploadButtonText() {
            return this.isUploading ? 'Uploading...' : 'Upload';
        }
    },
    watch: {
        title(value) {
            this.title = value;
            this.validateDocumentTitle(value);
        },
        description(value) {
            this.description = value;
            this.validateDocumentDescription(value);
        },
        uploadLocal(value) {
            if (value && this.validationErrMsg.upload_to) {
                delete this.validationErrMsg.upload_to;
            }
        },
        uploadAws(value) {
            if (value && this.validationErrMsg.upload_to) {
                delete this.validationErrMsg.upload_to;
            }
        }
    }
}
</script>