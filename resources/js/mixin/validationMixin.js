import { isEmpty, isNull } from "lodash";

export default {
    data() {
        return {
            validationErrMsg: {},
        };
    },
    methods: {
        validateDocumentTitle(title) {
            this.validationErrMsg.title = [];
            if (isEmpty(title) || isNull(title)) {
                this.validationErrMsg.title.push("Title is required.");
                return false;
            }
            if (title.length > 100) {
                this.validationErrMsg.title.push(
                    "Title must not be more than 100 characters."
                );
                return false;
            }

            delete this.validationErrMsg.title;
            return true;
        },
        validateDocumentDescription(description) {
            this.validationErrMsg.description = [];
            if (description.length > 500) {
                this.validationErrMsg.description.push(
                    "Description must not be more than 500 characters."
                );
                return false;
            }

            delete this.validationErrMsg.description;
            return true;
        },
        validateDocumentFile(fileType, fileSize) {
            this.validationErrMsg.doc_file = [];
            var allowedExtensionsRegx =
                /(\.jpg|\.jpeg|\.png|\.csv|\.txt|\.xlsx|\.pdf)$/i;
            var uploadSize = Math.round(fileSize / 1024);
            var isFileTypeAllowed = allowedExtensionsRegx.test(fileType);
            if (!isFileTypeAllowed) {
                this.validationErrMsg.doc_file.push(
                    "Document file type must be jpg,jpeg,png,csv,txt,xlsx,pdf."
                );
                return false;
            }
            if (uploadSize > 2 * 1024) {
                this.validationErrMsg.doc_file.push(
                    "Document file type must be less than or equal to 2MB."
                );
                return false;
            }

            delete this.validationErrMsg.doc_file;
            return true;
        },
    },
};
