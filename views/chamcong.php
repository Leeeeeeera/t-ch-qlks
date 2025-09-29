<?php
// views/chamcong.php
// Biến cần có (controller phải truyền):
// $nhanvienList, $chamcongList, $editData, $message, $error, $isAdmin

if (!isset($nhanvienList)) $nhanvienList = [];
if (!isset($chamcongList)) $chamcongList = [];
if (!isset($editData)) $editData = null;
if (!isset($message)) $message = '';
if (!isset($error)) $error = false;
if (!isset($isAdmin)) $isAdmin = false;

// Nếu bạn có layout header ở đường dẫn này, include nó.
// Nếu không có, bạn có thể thay bằng include 'header.php';
@include __DIR__ . '/layouts/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Quản lý Chấm công</title>

    <!-- Tailwind (nếu layout header chưa load) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root{
            --primary: #1d4d84;
            --secondary: #eaf3fd;
        }
        body { font-family: Inter, sans-serif; background:#f8fafc; color:#0f172a; }
    </style>
</head>
<body class="bg-gray-50 font-sans">
<main class="container mx-auto p-4 sm:p-8">

    <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
        <h2 class="text-3xl sm:text-4xl font-bold text-[var(--primary)] mb-4 sm:mb-0">Quản lý Chấm công</h2>
    </div>

    <?php if ($message): ?>
        <div id="alert-message" class="p-4 mb-6 rounded-lg font-medium <?= $error ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 mb-8">
        <h3 class="text-xl sm:text-2xl font-semibold text-[var(--primary)] mb-6">
            <?= $editData ? 'Chỉnh Sửa Chấm Công' : 'Thêm Chấm Công Mới' ?>
        </h3>

        <!-- FORM thêm / sửa gửi về controller -->
        <form method="post" action="index.php?controller=chamcong&action=index">
            <?php if ($editData): ?>
                <input type="hidden" name="id_chamcong" value="<?= htmlspecialchars($editData['id_chamcong']) ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="flex flex-col">
                    <label for="id_nhanvien" class="mb-2 text-sm font-medium text-gray-700">Nhân viên:</label>
                    <select id="id_nhanvien" name="id_nhanvien" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-primary focus:border-primary">
                        <option value="">-- Chọn nhân viên --</option>
                        <?php foreach ($nhanvienList as $nv): ?>
                            <option value="<?= htmlspecialchars($nv['id_nhanvien']) ?>"
                                <?= $editData && $editData['id_nhanvien'] == $nv['id_nhanvien'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($nv['ho_ten']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="thang" class="mb-2 text-sm font-medium text-gray-700">Tháng:</label>
                    <input type="number" id="thang" name="thang" placeholder="Tháng" min="1" max="12" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-primary focus:border-primary"
                           value="<?= $editData ? htmlspecialchars($editData['thang']) : date('m') ?>">
                </div>

                <div class="flex flex-col">
                    <label for="nam" class="mb-2 text-sm font-medium text-gray-700">Năm:</label>
                    <input type="number" id="nam" name="nam" placeholder="Năm" min="2000" max="2100" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-primary focus:border-primary"
                           value="<?= $editData ? htmlspecialchars($editData['nam']) : date('Y') ?>">
                </div>

                <div class="flex flex-col">
                    <label for="so_ngay_di_lam" class="mb-2 text-sm font-medium text-gray-700">Số ngày đi làm:</label>
                    <input type="number" id="so_ngay_di_lam" name="so_ngay_di_lam" placeholder="Số ngày đi làm" min="0" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-primary focus:border-primary"
                           value="<?= $editData ? htmlspecialchars($editData['so_ngay_di_lam']) : '' ?>">
                </div>

                <div class="flex flex-col">
                    <label for="so_ngay_nghi_co_phep" class="mb-2 text-sm font-medium text-gray-700">Số ngày nghỉ có phép:</label>
                    <input type="number" id="so_ngay_nghi_co_phep" name="so_ngay_nghi_co_phep" placeholder="Số ngày nghỉ có phép" min="0" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-primary focus:border-primary"
                           value="<?= $editData ? htmlspecialchars($editData['so_ngay_nghi_co_phep']) : '' ?>">
                </div>

                <div class="flex flex-col">
                    <label for="so_ngay_nghi_khong_phep" class="mb-2 text-sm font-medium text-gray-700">Số ngày nghỉ không phép:</label>
                    <input type="number" id="so_ngay_nghi_khong_phep" name="so_ngay_nghi_khong_phep" placeholder="Số ngày nghỉ không phép" min="0" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-primary focus:border-primary"
                           value="<?= $editData ? htmlspecialchars($editData['so_ngay_nghi_khong_phep']) : '' ?>">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 mt-6">
                <button type="submit" name="submit"
                        class="px-6 py-3 rounded-full text-white font-semibold transition-all duration-300 ease-in-out transform hover:scale-105 shadow-md
                               bg-[var(--primary)] hover:bg-indigo-700">
                    <?= $editData ? 'Cập nhật' : 'Thêm mới' ?>
                </button>

                <?php if ($editData): ?>
                    <a href="index.php?controller=chamcong&action=index"
                       class="px-6 py-3 rounded-full text-[var(--primary)] bg-gray-200 font-semibold transition-all duration-300 ease-in-out transform hover:scale-105 shadow-md hover:bg-gray-300">
                        Hủy
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 mb-8 border-l-4 border-yellow-500">
        <h3 class="text-xl sm:text-2xl font-semibold text-yellow-600 mb-4">Thông báo Quyền hạn</h3>
        <p class="text-gray-700">Chức năng <strong>Thêm</strong> và <strong>Chỉnh sửa</strong> dữ liệu chấm công chỉ dành cho tài khoản có quyền <strong>ADMIN</strong>.</p>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-[var(--primary)] text-white">
                    <tr>
                        <th class="p-4 font-semibold text-left rounded-tl-xl">STT</th>
                        <th class="p-4 font-semibold text-left">Nhân viên</th>
                        <th class="p-4 font-semibold text-left">Tháng</th>
                        <th class="p-4 font-semibold text-left">Năm</th>
                        <th class="p-4 font-semibold text-left">Số ngày đi làm</th>
                        <th class="p-4 font-semibold text-left">Nghỉ có phép</th>
                        <th class="p-4 font-semibold text-left">Nghỉ không phép</th>
                        <th class="p-4 font-semibold text-left rounded-tr-xl">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($chamcongList)): ?>
                        <?php $stt = 1; ?>
                        <?php foreach ($chamcongList as $cc): ?>
                            <tr class="border-b last:border-b-0 even:bg-gray-50 hover:bg-[var(--secondary)] transition-colors duration-200">
                                <td class="p-4 text-gray-800"><?= $stt++ ?></td>
                                <td class="p-4 text-gray-800"><?= htmlspecialchars($cc['ho_ten']) ?></td>
                                <td class="p-4 text-gray-800"><?= htmlspecialchars($cc['thang']) ?></td>
                                <td class="p-4 text-gray-800"><?= htmlspecialchars($cc['nam']) ?></td>
                                <td class="p-4 text-gray-800"><?= htmlspecialchars($cc['so_ngay_di_lam']) ?></td>
                                <td class="p-4 text-gray-800"><?= htmlspecialchars($cc['so_ngay_nghi_co_phep']) ?></td>
                                <td class="p-4 text-gray-800"><?= htmlspecialchars($cc['so_ngay_nghi_khong_phep']) ?></td>
                                <td class="p-4 space-x-2 flex items-center">
                                    <?php if ($isAdmin): ?>
                                        <a href="index.php?controller=chamcong&action=index&edit=<?= htmlspecialchars($cc['id_chamcong']) ?>" title="Sửa"
                                           class="text-blue-500 hover:text-blue-700 transition-colors duration-200">
                                            <!-- icon sửa (SVG) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 0 1 3 3L19 7 17 5l1.375-1.375z"/></svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">(Xem)</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">Chưa có dữ liệu chấm công nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<script>
    // Hide alert message after a few seconds
    const alertMessage = document.getElementById('alert-message');
    if (alertMessage) {
        setTimeout(() => {
            alertMessage.style.transition = 'opacity 0.5s ease-out';
            alertMessage.style.opacity = '0';
            setTimeout(() => { alertMessage.remove(); }, 500);
        }, 5000);
    }
</script>

<?php
// include footer layout nếu có (nếu không có file này, comment dòng dưới)
@include __DIR__ . '/layouts/footer.php';
?>
</body>
</html>
