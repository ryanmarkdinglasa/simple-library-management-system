<!-- Header & Breadcrumbs -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
									<?php if($parentpage!='' or $parentpage!=NULL){?>
                                    <li class="breadcrumb-item"><a href="./<?php echo $parentpage_link;?>"><?php echo $parentpage;?></a></li>
									<?php } ?>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $currentpage;?></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Header & Breadcrumbs -->