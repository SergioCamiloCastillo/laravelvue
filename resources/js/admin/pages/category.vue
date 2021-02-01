<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Category
                        <Button @click="addModal = true"
                            ><Icon type="md-add"></Icon> Add Category</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(category, i) in categories"
                                :key="i"
                                v-if="categories.length"
                            >
                                <td>{{ category.id }}</td>
                                <td class="_table_name">{{ category.categoryName }}</td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(category, i)"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeletingModal(category, i)"
                                        :loading="category.isDeleting"
                                        >Delete</Button
                                    >
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>
                <!-----Category Adding modal --->
                <Modal
                    v-model="addModal"
                    title="Add Category"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.categoryName"
                        placeholder="Add Category Name"
                    />
                    <div class="space"></div>
                    <Upload
                        multiple
                        type="drag"
                        ref="uploads"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :format="['jpg', 'jpeg', 'png']"
                        :on-format-error="handleFormatError"
                        :max-size="2048"
                        :on-exceeded-size="handleMaxSize"
                        action="/app/upload"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="data.iconImage">
                        <img :src="`/uploads/${data.iconImage}`" />
                        <div class="demo-upload-list-cover">
                            <Icon
                                type="ios-trash-outline"
                                @click="deleteImage"
                            ></Icon>
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addCategory"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Adding..." : "Add Category"
                            }}</Button
                        >
                    </div>
                </Modal>
                <!-------edit category-------->
                <Modal
                    v-model="editModal"
                    title="Edit Category"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.categoryName"
                        placeholder="Edit Category Name"
                    />
                    <div slot="footer">
                        <Button type="default" @click="editModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editCategory"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Editing..." : "Edit Category" }}</Button
                        >
                    </div>
                </Modal>
                <!---------Eliminar category------>
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to delete category?</p>
                    </div>
                    <div slot="footer">
                        <Button
                            type="error"
                            size="large"
                            :disabled="isDeleting"
                            long
                            :loading="isDeleting"
                            @click="deleteCategory"
                            >Delete</Button
                        >
                    </div>
                </Modal>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            data: {
                iconImage: "",
                categoryName: ""
            },
            editData: {
                categoryName: ""
            },
            addModal: false,
            idDeleting: false,
            editModal: false,
            isAdding: false,
            categories: [],
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1,
            token: ""
        };
    },
    methods: {
        async addCategory() {
            if (this.data.categoryName.trim() == "") return this.e("Category Name is required");

            if (this.data.iconImage.trim() == "") return this.e("Icon Image is required");

            const res = await this.callApi(
                "post",
                "app/create_category",
                this.data
            );
            if (res.status === 201) {
                this.categories.unshift(res.data);

                this.s("Category has been added successfully!");
                this.addModal = false;
                this.data.categoryName = "";
                this.data.iconImage = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.e(res.data.errors.categoryName[0]);
                    }
                    if (res.data.errors.iconImage) {
                        this.e(res.data.errors.iconImage[0]);
                    }
                } else {
                    this.swr();
                }
                this.data.categoryName = "";
            }
        },
        async deleteImage() {
            let image = this.data.iconImage;
            this.$refs.uploads.clearFiles();
            this.data.iconImage = "";
            const res = await this.callApi("post", "app/delete_image", {
                imageName: image
            });
            if (res.status != 200) {
                this.data.iconImage = image;
                this.swr();
            }
        },
        async editCategory() {
            if (this.editData.categoryName.trim() == "")
                return this.e("Category name is required");
            const res = await this.callApi(
                "post",
                "app/edit_category",
                this.editData
            );
            if (res.status === 200) {
                this.categories[this.index].categoryName = this.editData.categoryName;
                this.s("Category has been edited successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.e(res.data.errors.categoryName[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },

        async deleteCategory() {
            this.isDeleting = true;
            //  this.$set(category, "isDeleting", true);
            const res = await this.callApi(
                "post",
                "app/delete_category",
                this.deleteItem
            );
            if (res.status == 200) {
                this.categories.splice(this.deletingIndex, 1);
                this.s("Category has been deleted succesfully");
            } else {
                this.swr();
            }
            this.isDeleting = false;
            this.showDeleteModal = false;
        },
        showDeletingModal(category, i) {
            this.deleteItem = category;
            this.deletingIndex = i;
            this.showDeleteModal = true;
        },
        showEditModal(category, index) {
            let obj = {
                id: category.id,
                categoryName:category.categoryName
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },

        handleSuccess(res, file) {
            this.data.iconImage = res;
        },
        handleError(res, file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc: `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "Something went wrong"
                }`
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select jpg or png."
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M."
            });
        }
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi("get", "app/get_categories");
        if (res.status == 200) {
            this.categories = res.data;
        } else {
            this.swr();
        }
    }
};
</script>
