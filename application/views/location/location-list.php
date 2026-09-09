<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap gap-2 gap-md-3 mb-3">
            <a href="<?php echo base_url(); ?>location-list" class="<?php echo ($activeLink == '') ? 'bg-primary text-white' : 'bg-white text-primary'; ?> px-4 py-2 px-md-5 shadow shadow-sm fw-bold lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">All</a>
            <a href="<?php echo base_url(); ?>location-list/active" class="<?php echo ($activeLink == 'active') ? 'bg-success text-white' : 'bg-white text-success'; ?> px-4 py-2 px-md-5 shadow shadow-sm fw-bold lh-1 rounded-2 border-success border border-3 border-end-0 border-start-0 border-top-0">Active</a>
            <a href="<?php echo base_url(); ?>location-list/inactive" class="<?php echo ($activeLink == 'inactive') ? 'bg-danger text-white' : 'bg-white text-danger'; ?> px-4 py-2 px-md-5 shadow shadow-sm fw-bold lh-1 rounded-2 border-danger border border-3 border-end-0 border-start-0 border-top-0">Inactive</a>
        </div>
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-3 flex-wrap gap-3">
                <h4 class="fw-bold mb-0 text-black">Location Master List</h4>
                <a href="<?php echo base_url(); ?>location-add" class="btn btn-primary px-4 py-2 rounded text-white">Add Location</a>
            </div>
            <div class="table-responsive">
                <table class="zero_config table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="w-min-40">S. No</th>
                            <th>Location Name</th>
                            <th>Fees Amount (₹)</th>
                            <th>Status</th>
                            <th class="w-min-50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach ($locationList as $row) { 
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row->location_name; ?></td>
                            <td>₹ <?php echo number_format($row->fees_amount, 2); ?></td>
                            <td>
                                <?php if($row->status == 'active') { ?>
                                    <a href="javascript:void(0);" data-value="inactive" data-tablename="location" data-rowid="<?php echo $row->id; ?>" data-link="<?php echo base_url(); ?>location-list" class="text-success changeStatus" data-toggle="tooltip" data-placement="top" title="Status Change"> Active </a>
                                <?php } elseif($row->status == 'inactive') { ?>
                                    <a href="javascript:void(0);" data-value="active" data-tablename="location" data-rowid="<?php echo $row->id; ?>" data-link="<?php echo base_url(); ?>location-list" class="text-danger changeStatus" data-toggle="tooltip" data-placement="top" title="Status Change"> Inactive </a>
                                <?php } ?>
                            </td>
                            <td class="px-2">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="javascript:void(0);" class="box-hover getLocationId" data-locationid="<?php echo $row->id; ?>" data-bs-toggle="modal" data-bs-target="#view_modal" data-toggle="tooltip" data-placement="top" title="View"> <i class="bx bx-show-alt"></i> </a>
                                    <a href="<?php echo base_url() . 'location-edit/' . $row->id; ?>" class="box-hover" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="bx bx-edit-alt"></i> </a>
                                    <a href="javascript:void(0);" data-rowid="<?php echo $row->id; ?>" data-tablename="location" data-link="<?php echo base_url(); ?>location-list" class="box-hover trashItem" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="bx bx-trash"></i> </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="view_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3 border-bottom pb-3">
                    <div class="float-end">
                        <a href="javascript:void(0);" class="w-px-30 h-px-30 bg-label-dark rounded-circle d-flex align-items-center justify-content-center" data-bs-dismiss="modal">
                            <i class="bx bx-x text-black"></i>
                        </a>
                    </div>
                    <div id="headingTitle"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="w-100 fw-bold text-black mb-1">Location Name</label>
                        <div id="viewLocationName" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="w-100 fw-bold text-black mb-1">Fees Amount</label>
                        <div id="viewFeesAmount" class="text-black"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="w-100 fw-bold text-black mb-1">Status</label>
                        <div id="viewStatus" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="w-100 fw-bold text-black mb-1">Created By</label>
                        <div id="viewCreatedBy" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="w-100 fw-bold text-black mb-1">Created At</label>
                        <div id="viewCreatedAt" class="text-capitalize text-black"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".getLocationId", function(e){
        var locationId = $(this).data("locationid");
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>getLocationDetail',
            dataType: "json",
            data: {locationId: locationId},
            success: function (data) {
                $('#headingTitle').html('<h5 class="mb-0 text-black text-center lh-base fw-bold text-capitalize">' + data.locationName + ' Details</h5>');
                $('#viewLocationName').html(data.locationName);
                $('#viewFeesAmount').html('₹ ' + parseFloat(data.feesAmount).toFixed(2));
                $('#viewStatus').html(data.status);
                $('#viewCreatedBy').html(data.createdBy);
                $('#viewCreatedAt').html(data.createdAt);
            }
        });
        e.preventDefault();
        return false;
    });
</script>
