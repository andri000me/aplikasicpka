<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">        
                    <div class="card-body ">
                        <div class="card-title">
                            <div class="text-center">
                                <h4>Laporan Penagihan Per Customer</h4>
                            </div>
                            <hr>
                        </div>
                        <form method="post" role="form" action="<?= site_url('penagihan/laporan_penagihan') ?>" target="_blank">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select name="customer" class="form-control">
                                        <option value="" disabled selected>Pilih Customer</option>
                                            <?php foreach($data_customer as $customer) : ?>
                                            <option value="<?= $customer['id'] ?>"><?= $customer['namaCustomer'] ?></option>
                                            <?php endforeach; ?>                        
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <button class="btn btn-sm btn-info" type="submit"><i class="fa fa-print"></i> Tampilkan</button>
                                    </div>
                                </div>
                            </div>

                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>