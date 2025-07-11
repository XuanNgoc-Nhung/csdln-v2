# Hướng dẫn sử dụng hệ thống lưu file tùy chỉnh

## Tổng quan
Hệ thống cho phép tùy chỉnh việc lưu file vào 3 vị trí khác nhau:
- **config**: Lưu vào đường dẫn được cấu hình trong config
- **storage**: Lưu vào `storage/app/public/exportExcel/` (mặc định)
- **public**: Lưu vào `public/exportExcel/`

## Cấu hình

### 1. Cấu hình trong file .env
```env
# Loại storage mặc định: 'config', 'storage', 'public'
FILE_STORAGE_TYPE=storage

# Đường dẫn cho config storage (chỉ cần khi FILE_STORAGE_TYPE=config)
PATH_FILE=/path/to/your/custom/directory/
```

### 2. Cấu hình trong config/app.php
```php
'file_storage_type' => env('FILE_STORAGE_TYPE', 'storage'),
'path_file' => env('PATH_FILE'),
```

## Sử dụng trong Controller

### 1. Thay đổi loại storage
```php
// Thay đổi sang lưu vào public
$this->setFilePathConfig('public');

// Thay đổi sang lưu vào config path
$this->setFilePathConfig('config');

// Thay đổi về storage (mặc định)
$this->setFilePathConfig('storage');
```

### 2. Lưu file
```php
// Tự động lưu theo cấu hình hiện tại
$filePath = $this->saveFile($fileName, $content);
```

### 3. Kiểm tra và quản lý
```php
// Lấy loại storage hiện tại
$currentType = $this->getFilePathConfig();

// Kiểm tra thư mục có tồn tại không
$exists = $this->checkStorageDirectory();

// Tạo thư mục nếu chưa có
$this->createStorageDirectory();

// Lấy đường dẫn đầy đủ
$path = $this->getStoragePath();

// Reset về cấu hình mặc định
$this->resetToDefaultConfig();

// Lấy thông tin chi tiết
$info = $this->getStorageInfo();
```

## Ví dụ sử dụng

### Ví dụ 1: Lưu file Excel vào public
```php
public function exportToPublic(Request $request) {
    // Tạm thời chuyển sang public
    $this->setFilePathConfig('public');
    
    // Lưu file
    $fileName = 'report.xlsx';
    $content = $this->generateExcelContent();
    $filePath = $this->saveFile($fileName, $content);
    
    // Reset về mặc định
    $this->resetToDefaultConfig();
    
    return response()->json(['file' => $filePath]);
}
```

### Ví dụ 2: Kiểm tra và tạo thư mục
```php
public function ensureStorageReady() {
    if (!$this->checkStorageDirectory()) {
        $this->createStorageDirectory();
    }
    
    $info = $this->getStorageInfo();
    return response()->json($info);
}
```

### Ví dụ 3: Lưu file theo loại khác nhau
```php
public function exportWithCustomStorage(Request $request) {
    $storageType = $request->get('storage_type', 'storage');
    $this->setFilePathConfig($storageType);
    
    $fileName = 'custom_report.xlsx';
    $content = $this->generateExcelContent();
    $filePath = $this->saveFile($fileName, $content);
    
    return response()->json([
        'storage_type' => $storageType,
        'file_path' => $filePath,
        'web_url' => $this->getWebUrl($fileName)
    ]);
}
```

## Lưu ý quan trọng

1. **Quyền thư mục**: Đảm bảo web server có quyền ghi vào thư mục được chọn
2. **Symbolic link**: Nếu sử dụng storage, cần tạo symbolic link: `php artisan storage:link`
3. **Bảo mật**: Public storage có thể truy cập trực tiếp từ web, cần cân nhắc bảo mật
4. **Backup**: Nên có kế hoạch backup cho dữ liệu quan trọng

## Cấu trúc thư mục

```
project/
├── public/
│   └── exportExcel/          # Public storage
├── storage/
│   └── app/
│       └── public/
│           └── exportExcel/  # Storage (mặc định)
└── custom/path/              # Config storage (tùy chỉnh)
    └── exportExcel/
```

## Troubleshooting

### Lỗi không tạo được thư mục
- Kiểm tra quyền ghi của web server
- Kiểm tra đường dẫn có hợp lệ không

### File không truy cập được từ web
- Kiểm tra symbolic link cho storage
- Kiểm tra cấu hình web server
- Kiểm tra URL trả về có đúng không 