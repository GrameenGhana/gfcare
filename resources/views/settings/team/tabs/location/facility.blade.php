            <!-- Facilities -->
            <div class="panel panel-default" v-for="ftype in facilityTypes" >
                <div class="panel-heading">
                    @{{ ftype | pluralize  }}
                    
                    <button class="btn btn-default pull-right" @click.prevent="addFacility(ftype)">
                        <i class="fa fa-btn fa-plus"></i>Add @{{ ftype }}
                    </button> 
                </div>
                
                <div class="panel-body" v-if="user && facByType(ftype).length>0">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>@{{ ftype }}</th>
                                <th>Location</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="facility in facByType(ftype)">
              
                                <td class="spark-table-pad">
                                    @{{ facility.name }}
                                </td>

                                <td class="spark-table-pad">
                                    @{{ facility.location_id | location_name }}
                                </td>
                                
                                <td class="spark-table-pad">
                                                                                                       
                                    <button class="btn btn-danger pull-right" @click.prevent="removeFacility(facility)" :disabled="removingFacility(facility.id)">
                                        <span v-if="removingFacility(facility.id)">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i> Removing
                                        </span>
                                        <span v-else>
                                            <i class="fa fa-btn fa-trash-o"></i> Remove
                                        </span>
                                    </button>
                                                                        
                                    
                                    
                                     <button class="btn btn-default pull-right" style="margin-right: 10px"  @click.prevent="editFacility(facility)">
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
