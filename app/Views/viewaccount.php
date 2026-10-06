<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<section class="section-padding bg-light-custom">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card p-4">

                    <div class="mb-4">

                        <a
                            href="<?= base_url('accounts') ?>"
                            class="btn btn-secondary"
                        >
                            ← Back to Customer Accounts
                        </a>

                        <a
                            href="<?= base_url('account/edit/' . $account['id']) ?>"
                            class="btn btn-warning"
                        >
                            Edit
                        </a>

                        <form
                            method="post"
                            action="<?= base_url('account/delete/' . $account['id']) ?>"
                            class="d-inline"
                            onsubmit="return confirm('Delete this customer account?');"
                        >
                            <?= csrf_field() ?>

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >
                                Delete
                            </button>
                        </form>

                    </div>

                    <h2 class="text-primary-custom mb-4">
                        Customer Account Details
                    </h2>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <strong>Account Number</strong>
                            <p><?= esc($account['account_number']) ?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Status</strong>
                            <p><?= ucfirst(esc($account['status'])) ?></p>
                        </div>

                        <div class="col-md-12">
                            <strong>Customer Name</strong>
                            <p><?= esc($account['customer_name']) ?></p>
                        </div>

                        <div class="col-md-12">
                            <strong>Address</strong>
                            <p><?= esc($account['address']) ?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Phone</strong>
                            <p><?= esc($account['phone']) ?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Email</strong>
                            <p><?= esc($account['email']) ?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Meter Number</strong>
                            <p><?= esc($account['meter_number']) ?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Connection Type</strong>
                            <p><?= ucfirst(esc($account['connection_type'])) ?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Created At</strong>
                            <p><?= esc($account['created_at']) ?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Updated At</strong>
                            <p><?= esc($account['updated_at']) ?></p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<?= $this->endSection() ?>