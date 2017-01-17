            <!-- Locations -->
            <div class="panel panel-default" v-for="ltype in locationTypes" >
                <div class="panel-heading">
                    @{{ ltype | pluralize  }}
                    
                    <button class="btn btn-default pull-right" @click.prevent="addLocation(ltype)">
                        <i class="fa fa-btn fa-plus"></i>Add @{{ ltype }}
                    </button> 
                </div>
                
                <div class="panel-body" v-if="user && locByType(ltype).length>0">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>@{{ ltype }}</th>
                                <th v-if="locTypeIdx(ltype)">@{{ ltype | location_parent_type }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="location in locByType(ltype)">
              
                                <td class="spark-table-pad">
                                    @{{ location.name }}
                                </td>

                                <td class="spark-table-pad" v-if="locTypeIdx(ltype)">
                                    @{{ location.parent_id | location_parent }}
                                </td>
                                
                                <td class="spark-table-pad">
                                                                                                       
                                    <button class="btn btn-danger pull-right" @click.prevent="removeLocation(location)" :disabled="removingLocation(location.id)">
                                        <span v-if="removingLocation(location.id)">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i> Removing
                                        </span>
                                        <span v-else>
                                            <i class="fa fa-btn fa-trash-o"></i> Remove
                                        </span>
                                    </button>
                                                                        
                                    
                                    
                                     <button class="btn btn-default pull-right" style="margin-right: 10px"  @click.prevent="editLocation(location)">
                                            <i class="fa fa-btn fa-edit"></i> Edit
                                    </button>


                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else class="panel-body">
                    No @{{ ltype | lowercase | pluralize }} found.
                </div>
            </div>
