<gfcare-mm-campaign-screen inline-template>

    <!-- Clients -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Campaigns
            <button class="btn btn-default pull-right" @click.prevent="addCampaign()">
                <i class="fa fa-btn fa-plus"></i>Add Campaign
            </button> 
        </div>

        <div class="panel-body" v-if="campaigns.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="campaign in campaigns">

                        <td class="spark-table-pad">@{{ campaign.name }}</td>
                        <td class="spark-table-pad">@{{ campaign.description }}</td>
                        <td class="spark-table-pad">@{{ campaign.start_date }}</td>
                        <td class="spark-table-pad">@{{ campaign.end_date }}</td>

                        <td class="spark-table-pad">

                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeCampaign(campaign)" :disabled="removingCampaign(campaign.id)">
                                <span v-if="removingCampaign(campaign.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editCampaign(campaign)">
                                    <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No campaigns found.
        </div>
    </div>
    
    @include('MobileMidwife::service.add-campaign')
   

</gfcare-mm-campaign-screen>
