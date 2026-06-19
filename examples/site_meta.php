<?php

/**
 * 站点元信息配置与描述生成器
 *
 * 本文件负责管理示例站点的元数据，并提供根据规则生成简短描述的能力。
 * 该模块主要用于演示如何在静态页面或简单框架中组织站点信息。
 */

final class SiteMeta {

    private string $url;
    private string $name;
    private string $description;
    private array $keywords;

    public function __construct(
        string $url,
        string $name,
        string $description,
        array $keywords
    ) {
        $this->url = $url;
        $this->name = $name;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    /**
     * 生成一个包含站点名称和核心关键词的简短描述。
     * 使用 HTML 转义输出，防止跨站脚本。
     *
     * @return string 转义后的描述文本
     */
    public function generateDescription(): string {
        $safeName = htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
        $safeKeyword = htmlspecialchars($this->keywords[0] ?? '', ENT_QUOTES, 'UTF-8');

        return sprintf(
            '%s – 专注于%s的在线平台。访问 %s 获取最新信息。',
            $safeName,
            $safeKeyword,
            htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8')
        );
    }

    /**
     * 为一个页面生成 meta 标签内容（示例用）。
     *
     * @return string 包含元标签的 HTML 片段
     */
    public function renderMetaTags(): string {
        $escapedDescription = $this->generateDescription();
        $escapedKeywords = implode(', ', array_map(function($keyword) {
            return htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
        }, $this->keywords));

        return <<<META
<meta name="description" content="{$escapedDescription}" />
<meta name="keywords" content="{$escapedKeywords}" />
META;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getName(): string {
        return $this->name;
    }
}

// ---------------------------------------------------------------------
// 示例数据：可以替换为真实配置（如数据库、JSON 等）
// 这里直接写入演示内容，用于测试元信息生成。
// ---------------------------------------------------------------------
$site = new SiteMeta(
    'https://h5portal-leyu.com.cn',
    '乐鱼体育',
    '提供多元化体育赛事资讯与互动。',
    ['乐鱼体育', '体育赛事', '娱乐平台', '在线体育']
);

echo $site->generateDescription() . "\n";
echo $site->renderMetaTags() . "\n";