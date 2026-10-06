<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>
    .accounts-section {
        background-color: #f8fafc;
        min-height: 80vh;
        padding: 60px 0;
    }

    .accounts-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .stats-card {
        color: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .card-total {
        background: #1e40af;
    }

    .card-active {
        background: #10b981;
    }

    .card-inactive {
        background: #dc3545;
    }

    .card-suspended {
        background: #f59e0b;
    }

    .search-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .badge-active {
        background-color: #28a745;
    }

    .badge-inactive {
        background-color: #dc3545;
    }

    .badge-suspended {
        background-color: #ffc107;
        color: black;
    }


    /* =========================
   PAGINATION STYLE
   ========================= */

    .pagination-card {
        margin-top: 40px;
        background: #ffffff;
        border-radius: 0 0 24px 24px;
        min-height: 120px;
        padding: 30px 32px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-top: 1px solid #f1f1f1;
    }

    .pagination-info {
        font-size: 18px;
        font-weight: 400;
        color: #111827;
    }

    .pagination-numbers {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pagination-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 32px;
        height: 32px;

        padding: 0 6px;

        font-size: 18px;
        text-decoration: none;

        color: #2563eb;
        background: transparent;

        border-radius: 6px;
    }

    .pagination-number:hover {
        background: #f1f5f9;
        color: #1d4ed8;
    }

    .pagination-number.active {
        color: #111827;
        font-weight: 600;
    }
</style>


<section class="accounts-section">

    <div class="container">

        <div class="accounts-container">

            <div class="mb-4">

                <h1 class="fw-bold text-primary-custom">
                    Customer Accounts
                </h1>

                <p class="text-muted">
                    Puihaha Electric Customer Account Management
                </p>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <a href="<?= base_url('account/new') ?>" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Add Customer Account
                </a>

            </div>


            <!-- Statistics -->

            <div class="row">

                <div class="col-md-3">

                    <div class="stats-card card-total">

                        <h2>
                            <?= $total_accounts ?>
                        </h2>

                        <p class="mb-0">
                            Total Accounts
                        </p>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="stats-card card-active">

                        <h2>
                            <?= $active_accounts ?>
                        </h2>

                        <p class="mb-0">
                            Active
                        </p>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="stats-card card-inactive">

                        <h2>
                            <?= $inactive_accounts ?>
                        </h2>

                        <p class="mb-0">
                            Inactive
                        </p>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="stats-card card-suspended">

                        <h2>
                            <?= $suspended_accounts ?>
                        </h2>

                        <p class="mb-0">
                            Suspended
                        </p>

                    </div>

                </div>

            </div>


            <!-- Search and Filters -->

            <div class="search-box">

                <form
                    method="GET"
                    action="<?= base_url('accounts') ?>">

                    <div class="row g-3">

                        <div class="col-md-4">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search name, account, email or phone"
                                value="<?= esc($search_keyword ?? '') ?>">

                        </div>


                        <div class="col-md-3">

                            <select
                                name="status"
                                class="form-select">

                                <option value="">
                                    All Status
                                </option>

                                <option
                                    value="active"
                                    <?= ($filter_status ?? '') === 'active'
                                        ? 'selected'
                                        : '' ?>>
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    <?= ($filter_status ?? '') === 'inactive'
                                        ? 'selected'
                                        : '' ?>>
                                    Inactive
                                </option>

                                <option
                                    value="suspended"
                                    <?= ($filter_status ?? '') === 'suspended'
                                        ? 'selected'
                                        : '' ?>>
                                    Suspended
                                </option>

                            </select>

                        </div>


                        <div class="col-md-3">

                            <select
                                name="type"
                                class="form-select">

                                <option value="">
                                    All Types
                                </option>

                                <option
                                    value="residential"
                                    <?= ($filter_type ?? '') === 'residential'
                                        ? 'selected'
                                        : '' ?>>
                                    Residential
                                </option>

                                <option
                                    value="commercial"
                                    <?= ($filter_type ?? '') === 'commercial'
                                        ? 'selected'
                                        : '' ?>>
                                    Commercial
                                </option>

                                <option
                                    value="industrial"
                                    <?= ($filter_type ?? '') === 'industrial'
                                        ? 'selected'
                                        : '' ?>>
                                    Industrial
                                </option>

                            </select>

                        </div>


                        <div class="col-md-2">

                            <button
                                type="submit"
                                class="btn btn-primary w-100">
                                Search
                            </button>

                        </div>

                    </div>

                </form>


                <?php if (
                    $search_keyword ||
                    $filter_status ||
                    $filter_type
                ): ?>

                    <div class="mt-3">

                        <a
                            href="<?= base_url('accounts') ?>"
                            class="btn btn-secondary btn-sm">
                            Clear Filters
                        </a>

                    </div>

                <?php endif; ?>

            </div>


            <!-- Customer Table -->

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>Account Number</th>

                            <th>Customer Name</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>Type</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (empty($accounts)): ?>

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted">
                                    No accounts found.
                                </td>

                            </tr>

                        <?php else: ?>

                            <?php foreach ($accounts as $account): ?>

                                <tr>

                                    <td>

                                        <strong>
                                            <?= esc(
                                                $account['account_number']
                                            ) ?>
                                        </strong>

                                    </td>


                                    <td>
                                        <?= esc(
                                            $account['customer_name']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= esc(
                                            $account['email']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= esc(
                                            $account['phone']
                                        ) ?>
                                    </td>


                                    <td>

                                        <span class="badge bg-info text-dark">

                                            <?= ucfirst(
                                                esc(
                                                    $account['connection_type']
                                                )
                                            ) ?>

                                        </span>

                                    </td>


                                    <td>

                                        <?php

                                        $badgeClass =
                                            'badge-' .
                                            $account['status'];

                                        ?>

                                        <span
                                            class="badge <?= $badgeClass ?>">

                                            <?= ucfirst(
                                                esc(
                                                    $account['status']
                                                )
                                            ) ?>

                                        </span>

                                    </td>


                                    <td>

                                        <a
                                            href="<?= base_url(
                                                        'account/' .
                                                            $account['id']
                                                    ) ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>

                                        <a
                                            href="<?= base_url('account/edit/' . $account['id']) ?>"
                                            class="btn btn-sm btn-outline-warning">
                                            Edit
                                        </a>

                                        <form
                                            method="post"
                                            action="<?= base_url('account/delete/' . $account['id']) ?>"
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this customer account?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <!-- PAGINATION -->

            <?php if ($pager): ?>

                <?php

                $totalPages = $pager->getPageCount();

                $currentPage =
                    (int) ($current_page ?? 1);

                $search =
                    $search_keyword ?? '';

                $status =
                    $filter_status ?? '';

                $type =
                    $filter_type ?? '';

                ?>

                <div class="pagination-card">

                    <div class="pagination-info">

                        Page
                        <?= $currentPage ?>
                        of
                        <?= $totalPages ?>

                    </div>


                    <div class="pagination-numbers">

                        <?php
                        for (
                            $page = 1;
                            $page <= $totalPages;
                            $page++
                        ):
                        ?>

                            <?php

                            $query = http_build_query([
                                'page' => $page,
                                'search' => $search,
                                'status' => $status,
                                'type' => $type
                            ]);

                            $url =
                                base_url('accounts')
                                . '?'
                                . $query;

                            ?>

                            <a
                                href="<?= $url ?>"
                                class="pagination-number
                                <?= $page === $currentPage
                                    ? 'active'
                                    : '' ?>">
                                <?= $page ?>
                            </a>

                        <?php endfor; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>

<?= $this->endSection() ?>