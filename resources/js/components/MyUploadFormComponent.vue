<style>
    input[type="file"]{
        position: absolute;
        top: -2500px;
        left: -2500px;
    }

    div.file-listing{
        width: 200px;
    }

    span.remove-file{
        color: red;
        cursor: pointer;
        float: right;
    }
</style>

<template>
    <div class="container">
        <div v-if="isError" class="row">
            <div class="col alert-danger">{{errorMsg}}</div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="image_small">Small image (110x110):</label>
                <input id="image_small" ref="image_small" name="image_small[]" type="file" multiple
                       v-on:change="handleFilesUploadSmall">
                <div class="large-12 medium-12 small-12 cell">
                    <button class="btn btn-secondary form-control-file" v-on:click="addFilesSmall()">Add Files</button>
                </div>
                <label>Selected {{smallCount}}</label>
                <div class="large-12 medium-12 small-12 cell">
                    <div v-for="(file, key) in images_small" class="file-listing">{{ file.name }}</div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="image_medium">Medium image (250x250):</label>
                <input id="image_medium" ref="image_medium" name="image_medium[]" type="file" multiple
                       v-on:change="handleFilesUploadMedium">
                <div class="large-12 medium-12 small-12 cell">
                    <button class="btn btn-secondary form-control-file" v-on:click="addFilesMedium()">Add Files</button>
                </div>
                <label>Selected {{mediumCount}}</label>
                <div class="large-12 medium-12 small-12 cell">
                    <div v-for="(file, key) in images_medium" class="file-listing">{{ file.name }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="image_large">Large image (450x450):</label>
                <input id="image_large" ref="image_large" name="image_large[]" type="file" multiple
                       v-on:change="handleFilesUploadLarge">
                <div class="large-12 medium-12 small-12 cell">
                    <button class="btn btn-secondary form-control-file" v-on:click="addFilesLarge()">Add Files</button>
                </div>
                <label>Selected {{largeCount}}</label>
                <div class="large-12 medium-12 small-12 cell">
                    <div v-for="(file, key) in images_large" class="file-listing">{{ file.name }}</div>
                </div>
                <div class="large-12 medium-12 small-12 cell">
                    <div v-for="(message, key) in errorMsg.image_large" class="file-listing">{{ message}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 offset-4" style="margin-top:60px">
                <button :disabled="!submitEnabled" class="btn btn-primary form-control" v-on:click="submitFiles()">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['productId'],

        data() {
            return {
                images_small: [],
                images_medium: [],
                images_large: [],
                errorMsg: ""
            }
        },
        computed: {
            smallCount: function () {
                return this.images_small.length
            },
            mediumCount: function () {
                return this.images_medium.length
            },
            largeCount: function () {
                return this.images_large.length
            },
            submitEnabled: function() {
                return this.smallCount || this.mediumCount || this.largeCount
            },
            isError: function () {
                return this.errorMsg !==''
            }
        },
        methods: {
            addFilesSmall() {
                this.$refs.image_small.click();
            },
            addFilesMedium() {
                this.$refs.image_medium.click();
            },
            addFilesLarge() {
                this.$refs.image_large.click();
            },

            submitFiles() {
                let formData = new FormData();

                for (var i = 0; i < this.images_small.length; i++) {
                    let file = this.images_small[i];

                    formData.append('image_small[' + i + ']', file);
                }
                for (var i = 0; i < this.images_medium.length; i++) {
                    let file = this.images_medium[i];

                    formData.append('image_medium[' + i + ']', file);
                }
                for (var i = 0; i < this.images_large.length; i++) {
                    let file = this.images_large[i];

                    formData.append('image_large[' + i + ']', file);
                }

                /*
                  Make the request to the POST /select-files URL
                */
                axios.post('p' + this.productId + '/add_pictures',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function () {
                    location.reload()
                })
                    .catch(error=> {
                        if(error.response.status = 413)
                        {
                            console.log(error.response.statusText);
                            this.errorMsg = error.response.statusText
                        }
                        else
                        {
                            console.log(error.response.data.errors);
                            this.errorMsg = error.response.data.message
                        }
                        console.log('FAILURE!!');
                    });
            },

            /*
              Handles the uploading of files
            */
            handleFilesUploadSmall() {
                let uploadedFiles = this.$refs.image_small.files;

                /*
                  Adds the uploaded file to the files array
                */
                for (var i = 0; i < uploadedFiles.length; i++) {
                    this.images_small.push(uploadedFiles[i]);
                }
            },
            handleFilesUploadMedium() {
                let uploadedFiles = this.$refs.image_medium.files;

                /*
                  Adds the uploaded file to the files array
                */
                for (var i = 0; i < uploadedFiles.length; i++) {
                    this.images_medium.push(uploadedFiles[i]);
                }
            },
            handleFilesUploadLarge() {
                let uploadedFiles = this.$refs.image_large.files;

                /*
                  Adds the uploaded file to the files array
                */
                for (var i = 0; i < uploadedFiles.length; i++) {
                    this.images_large.push(uploadedFiles[i]);
                }
            },

            /*
              Removes a select file the user has uploaded
            */
            removeFile(key) {
                this.images_large.splice(key, 1);
            }
        }
    }
</script>
