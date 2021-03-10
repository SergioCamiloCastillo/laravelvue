<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Role Management
                        <Select
                            v-model="data.role_id"
                            style="width:200px"
                            placeholder="Select role"
                        >
                            <Option
                                :value="r.id"
                                v-for="(r, i) in roles"
                                :key="i"
                                v-if="roles.length"
                                >{{ r.roleName }}</Option
                            >
                        </Select>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Resource Name</th>
                                <th>Read</th>
                                <th>Write</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(r, i) in resources" :key="i">
                                <td>{{ r.resourceName }}</td>
                                <td>
                                    <Checkbox v-model="r.read"
                                        ></Checkbox
                                    >
                                </td>
                                 <td>
                                    <Checkbox v-model="r.write"
                                        ></Checkbox
                                    >
                                </td>
                                 <td>
                                    <Checkbox v-model="r.update"
                                        ></Checkbox
                                    >
                                </td>
                                 <td>
                                    <Checkbox v-model="r.delete"
                                        ></Checkbox
                                    >
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <!-- role editing modal -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                roleName: "",
                role_id: null
            },
            roles: [],
            resources: [
                  {
                    resourceName:'Home',
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: 'home'
                },
                {
                    resourceName: 'Tags',
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name:'tags'
                },
                {
                    resourceName: 'Category',
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: 'category'
                },
                {
                    resourceName: 'Adminusers',
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: 'adminusers'
                },
                {
                    resourceName: 'Role',
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: 'role'
                },
                {
                    resourceName: 'AssignRole',
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: 'assignRole'
                },
              
            ]
        };
    },
    methods: {},
    async created() {
        const res = await this.callApi("get", "app/get_roles");

        if (res.status == 200) {
            this.roles = res.data;
        } else {
            this.swr();
        }
    }
};
</script>
