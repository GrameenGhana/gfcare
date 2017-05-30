<spark-team-settings-module-screen inline-template>
    <div id="spark-settings-teams-screen">
        <div v-if="everythingIsLoaded">

            <!-- Enabled Modules -->
        <div class="panel panel-default">
                <div class="panel-heading">Project Modules</div>

                <div class="panel-body" v-if="user && team.modules.length > 0">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="module in team.modules">
                                <td class="spark-table-pad">
                                    @{{ module.module_id | module }}
                                </td>

                                <td class="spark-table-pad">
                                    @{{ module.module_id | module_description }}
                                </td>

                                <td class="spark-table-pad">
                                    <button class="btn btn-warning btn-sm" @click.prevent="switchStatus(module)" :disabled="switchingStatus" v-if="module.active">
                                        <span v-if="switchingStatus">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i> Disabling...
                                         </span>
                                        <span v-else>
                                            Disable Module
                                        </span>
                                    </button>
                                    
                                    <button v-else class="btn btn-success btn-sm" @click.prevent="switchStatus(module)" :disabled="switchingStatus">
                                        <span v-if="switchingStatus">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i> Enabling...
                                         </span>
                                        <span v-else>
                                            Enable Module
                                        </span>
                                    </button>
                                </td>

                                <td class="spark-table-pad">
                                    <button class="btn btn-danger" @click.prevent="removeModule(module)" :disabled="removingModule">
                                        <span v-if="removingModule">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i>Removing
                                 </span>
                                        <span v-else>
                                    <i class="fa fa-btn fa-times"></i>Remove Module
                                </span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else class="panel-body">
                    No Modules activated. Add modules from below.
                </div>
            </div>

            <!-- Available Modules -->
            <div class="panel panel-default" v-if="modules.length > 0">
                <div class="panel-heading">Available Modules</div>

                <div class="panel-body" v-if="modulesExceptMine.length > 0">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="module in modulesExceptMine">
                                <td class="spark-table-pad">
                                    @{{ module.name }}
                                </td>

                                <td class="spark-table-pad">
                                    @{{ module.description }}
                                </td>

                                <td class="spark-table-pad">
                                    <button v-if="module.active" class="btn btn-success" @click.prevent="addModule(module)" :disabled="addingModule">
                                        <span v-if="addingModule">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i>Adding
                                        </span>
                                        <span v-else>
                                            <i class="fa fa-btn fa-plus"></i>Add Module
                                        </span>
                                    </button>
                                    <button v-else class="btn btn-default" :disabled="true">
                                            <i class="fa fa-btn fa-plus"></i>Add Module
                                    </button>
                                </td>
                                <td class="spark-table-pad">
                                            <i v-if="module.active===false" style="font-size: 16px;"
                                               class="fa fa-info-circle"
                                               data-toggle="tooltip"
                                               data-placement="right"
                                               title="Module disabled by Administrator."/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="panel-body">
                    All available modules added to project.
                </div>
            </div>

            <div v-else class="panel panel-default">
                <div class="panel-heading">Available Modules</div>
                <div class="panel-body">
                    No Modules loaded. Please speak to administrator.
                </div>
            </div>

        </div>
    </div>
</spark-team-settings-module-screen>
