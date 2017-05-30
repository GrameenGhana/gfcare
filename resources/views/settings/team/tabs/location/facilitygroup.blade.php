            <!-- Facility Groups -->
            <div class="panel panel-default" v-for="ftype in facilityGroupTypes" >
                <div class="panel-heading">
                    @{{ ftype | pluralize  }}
                    
                    <button class="btn btn-default pull-right" @click.prevent="addFacilityGroup(ftype)">
                        <i class="fa fa-btn fa-plus"></i>Add @{{ ftype }}
                    </button> 
                </div>
                
                <div class="panel-body" v-if="user && facGroupByType(ftype).length>0">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>@{{ ftype }}</th>
                                <th>Facilities</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="fg in facGroupByType(ftype)">
              
                                <td class="spark-table-pad">
                                    @{{ fg.name }}
                                </td>

                                <td class="spark-table-pad">
                                    @{{ fg.facilities | facilitygroup_facilities }}
                                </td>
                                
                                <td class="spark-table-pad">
                                                                                                       
                                    <button class="btn btn-danger pull-right" @click.prevent="removeFacilityGroup(fg)" :disabled="removingFacilityGroup(fg.id)">
                                        <span v-if="removingFacilityGroup(fg.id)">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i> Removing
                                        </span>
                                        <span v-else>
                                            <i class="fa fa-btn fa-trash-o"></i> Remove
                                        </span>
                                    </button>
                                                                        
                                     <button class="btn btn-default pull-right" style="margin-right: 10px"  @click.prevent="editFacilityGroup(fg)">
                                            <i class="fa fa-btn fa-edit"></i> Edit
                                    </button>


                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else class="panel-body">
                    No @{{ ftype | lowercase | pluralize }} found.
                </div>
            </div>
