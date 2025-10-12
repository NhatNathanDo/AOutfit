<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class DescriptionGeneratorService
{
    public function generate(array $product, array $imageUrls = []): string
    {
        $apiKey = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4o-mini');

        $prompt = $this->buildPrompt($product, $imageUrls);

        if ($apiKey) {
            try {
                $resp = Http::withToken($apiKey)
                    ->timeout(20)
                    ->acceptJson()
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => $model,
                        'messages' => [
                            [ 'role' => 'system', 'content' => 'Bạn là một trợ lý viết nội dung sản phẩm thời trang, ngắn gọn, tự nhiên, thân thiện.' ],
                            [ 'role' => 'user', 'content' => $prompt ],
                        ],
                        'temperature' => 0.7,
                        'max_tokens' => 220,
                    ]);

                if ($resp->successful()) {
                    $text = data_get($resp->json(), 'choices.0.message.content');
                    if (is_string($text) && trim($text) !== '') {
                        return trim($text);
                    }
                }
            } catch (\Throwable $e) {
                // Fall through to fallback template
            }
        }

        // Fallback: simple template
        return $this->fallback($product);
    }

    protected function buildPrompt(array $p, array $imageUrls): string
    {
        $lines = [];
        $push = function ($k, $v) use (&$lines) { if ($v !== null && $v !== '') $lines[] = "$k: $v"; };
        $push('Tên', $p['name'] ?? null);
        $push('Giá', $p['price'] ?? null);
        $push('Danh mục', $p['category'] ?? null);
        $push('Nhãn hàng', $p['brand'] ?? null);
        $push('Giới tính', $p['gender'] ?? null);
        $push('Màu sắc', $p['color'] ?? null);
        $push('Chất liệu', $p['material'] ?? null);
        $push('Phong cách', $p['style'] ?? null);
        if (!empty($imageUrls)) {
            $lines[] = 'Ảnh tham chiếu:';
            foreach ($imageUrls as $u) { $lines[] = (string) $u; }
        }
        $ctx = implode("\n", $lines);
        return "Hãy viết mô tả sản phẩm thời trang bằng tiếng Việt (80-140 từ), giọng điệu thân thiện, nêu bật chất liệu, màu sắc, phong cách và gợi ý phối đồ.\n\n$ctx";
    }

    protected function fallback(array $p): string
    {
        $name = $p['name'] ?? 'Sản phẩm';
        $color = $p['color'] ?? null;
        $material = $p['material'] ?? null;
        $style = $p['style'] ?? null;

        $bits = [];
        $bits[] = "$name";
        if ($material) $bits[] = "chất liệu $material";
        if ($color) $bits[] = "tông $color";
        if ($style) $bits[] = "phong cách $style";
        $head = implode(', ', $bits);

        return trim("$head mang đến cảm giác thoải mái khi mặc và dễ dàng phối với nhiều trang phục hàng ngày. Thiết kế tối giản nhưng tinh tế, phù hợp đi làm, đi học hoặc dạo phố. Kết hợp cùng sneaker/trang sức tối giản để tạo điểm nhấn.\n\nLưu ý: Màu sắc có thể chênh lệch nhẹ tùy màn hình. Hãy chọn đúng size để có trải nghiệm tốt nhất.");
    }
}
