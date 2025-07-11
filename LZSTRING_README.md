# LZString Integration Guide

## Tổng quan

LZString đã được tích hợp thành công vào dự án Laravel của bạn. Package này cung cấp khả năng nén và giải nén dữ liệu string sử dụng thuật toán LZ77.

## Cài đặt

Package đã được cài đặt thông qua Composer:
```bash
composer require netom/lz-string-php
```

## Cách sử dụng

### 1. Sử dụng trực tiếp trong Controller

```php
use LZCompressor\LZString;

// Nén string
$compressed = LZString::compressToBase64("Hello World!");

// Giải nén string
$decompressed = LZString::decompressFromBase64($compressed);
```

### 2. Sử dụng Helper Functions

Đã có sẵn các helper functions trong `app/helper.php`:

```php
// Nén string
$compressed = lz_compress("Hello World!");

// Giải nén string
$decompressed = lz_decompress($compressed);

// Các phương thức khác
$compressed_utf16 = lz_compress_utf16("Hello World!");
$decompressed_utf16 = lz_decompress_utf16($compressed_utf16);

$compressed_uri = lz_compress_uri("Hello World!");
$decompressed_uri = lz_decompress_uri($compressed_uri);
```

### 3. Sử dụng Service Container

```php
$lzstring = app('lzstring');
$compressed = $lzstring->compressToBase64("Hello World!");
```

## Các phương thức có sẵn

### Base64 Encoding
- `compressToBase64($string)` - Nén string thành Base64
- `decompressFromBase64($string)` - Giải nén string từ Base64

### UTF16 Encoding
- `compressToUTF16($string)` - Nén string thành UTF16
- `decompressFromUTF16($string)` - Giải nén string từ UTF16

### URI Component Encoding
- `compressToEncodedURIComponent($string)` - Nén string thành URI component
- `decompressFromEncodedURIComponent($string)` - Giải nén string từ URI component

## Ví dụ sử dụng trong ApiGatewayController

```php
public function request(Request $request)
{
    $data = $request->get("data");
    $data = LZString::decompressFromBase64($data); // Giải nén dữ liệu
    $path = $request->get("path");
    $method = $request->get("method");

    // Xử lý dữ liệu đã giải nén
    $processor = HttpProcessorManager::getInstance()->getProcessor($this->helper, $method, $path, $data);
    if ($processor != null) {
        return $processor->request();
    }
    return null;
}
```

## Lưu ý

1. **Error Handling**: Tất cả helper functions đều có try-catch để xử lý lỗi. Nếu có lỗi, chúng sẽ trả về string gốc.

2. **Performance**: LZString rất hiệu quả cho việc nén dữ liệu text, đặc biệt là JSON data.

3. **Compatibility**: Package này tương thích với JavaScript LZString library, có thể sử dụng để trao đổi dữ liệu giữa frontend và backend.

## Service Provider

Đã tạo `LZStringServiceProvider` và đăng ký trong `config/app.php`. Service này có thể được inject vào các class khác:

```php
public function __construct()
{
    $this->lzstring = app('lzstring');
}
```

## Testing

Để test LZString, bạn có thể sử dụng:

```php
$original = "Test string";
$compressed = lz_compress($original);
$decompressed = lz_decompress($compressed);

// Kiểm tra
if ($original === $decompressed) {
    echo "LZString working correctly!";
}
``` 