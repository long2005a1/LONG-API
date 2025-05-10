<?php
// 设置时区为北京时间
date_default_timezone_set('Asia/Shanghai');

// 处理跨域请求
header('Content-Type: application/json');

// 动态验证并设置允许的来源（白名单方式）
$allowed_domains = [
    'https://www.long2024.cn',
    'https://yunpan.long2024.cn',
    'https://long2024.cn',
    'https://kk.long2024.cn'
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowed_domains)) {
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Credentials: true');
}

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Content-Length: 0');
    header('HTTP/1.1 204 No Content');
    exit;
}

// 安全获取客户端IP
function get_client_ip() {
    $trusted_proxies = ['192.168.1.1', '10.0.0.1']; // 替换为你的代理服务器IP
    $client_ip = '未知IP';

    // 优先使用 Cloudflare 的 IP
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
        $client_ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ips = array_map('trim', $ips);

        // 从右向左查找第一个非代理IP
        foreach (array_reverse($ips) as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP) &&!in_array($ip, $trusted_proxies)) {
                $client_ip = $ip;
                break;
            }
        }
    } elseif (isset($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {
        $client_ip = $_SERVER['REMOTE_ADDR'];
    }

    return $client_ip;
}

// 增强版IP信息获取函数
function get_ip_info($api_url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => false,
        CURLOPT_FAILONERROR => true,
        CURLOPT_HTTPHEADER => ['Accept: application/json']
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // 处理请求错误
    if ($http_code !== 200 || empty($response)) {
        return [
           'status' => 'error',
            'error' => "API请求失败: HTTP状态码 {$http_code}, 错误: {$error}"
        ];
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
           'status' => 'error',
            'error' => "JSON解析失败: " . json_last_error_msg()
        ];
    }

    return $data;
}

// 增强版用户代理解析函数
function parse_user_agent($user_agent) {
    $result = [
        'browser' => '未知浏览器',
        'browser_ver' => '未知版本',
        'os' => '未知系统'
    ];

    if (empty($user_agent)) {
        return $result;
    }

    // 浏览器检测规则（按优先级排序，特殊浏览器优先）
    $browsers = [
        // 特殊内置浏览器（优先级最高）
        '/MicroMessenger\/([\d.]+)/i' => function($matches) {
            return [
                'name' => '微信浏览器',
                'version' => $matches[1]
            ];
        },
        '/QQBrowser\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'QQ浏览器',
                'version' => $matches[1]
            ];
        },
        '/UC?Browser\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'UC浏览器',
                'version' => $matches[1]
            ];
        },
        '/Quark\/([\d.]+)/i' => function($matches) {
            return [
                'name' => '夸克浏览器',
                'version' => $matches[1]
            ];
        },
        '/MiuiBrowser\/([\d.]+)/i' => function($matches) {
            return [
                'name' => '小米浏览器',
                'version' => $matches[1]
            ];
        },
        '/SamsungBrowser\/([\d.]+)/i' => function($matches) {
            return [
                'name' => '三星浏览器',
                'version' => $matches[1]
            ];
        },
        // 主流现代浏览器
        '/Edg[ea]?\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Edge',
                'version' => $matches[1]
            ];
        },
        '/Chrome\/([\d.]+)(?!.*QQBrowser)(?!.*UC?Browser)(?!.*Quark)/i' => function($matches) {
            return [
                'name' => 'Chrome',
                'version' => $matches[1]
            ];
        },
        '/Firefox\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Firefox',
                'version' => $matches[1]
            ];
        },
        // Safari 版本提取
        '/Safari\/([\d.]+)(?:.*)Version\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Safari',
                'version' => $matches[2]
            ];
        },
        // 其他浏览器
        '/Opera|OPR\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Opera',
                'version' => $matches[1]
            ];
        },
        '/Brave\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Brave',
                'version' => $matches[1]
            ];
        },
        '/Vivaldi\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Vivaldi',
                'version' => $matches[1]
            ];
        },
        '/Yandex\/([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Yandex',
                'version' => $matches[1]
            ];
        },
        // 旧版浏览器
        '/MSIE\s([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Internet Explorer',
                'version' => $matches[1]
            ];
        },
        '/Trident\/.+rv:([\d.]+)/i' => function($matches) {
            return [
                'name' => 'Internet Explorer',
                'version' => $matches[1]
            ];
        },
    ];

    foreach ($browsers as $pattern => $processor) {
        if (preg_match($pattern, $user_agent, $matches)) {
            $browser_info = is_callable($processor) ? $processor($matches) : [
                'name' => $processor,
                'version' => isset($matches[1]) ? $matches[1] : '未知版本'
            ];

            $result['browser'] = $browser_info['name'];
            $result['browser_ver'] = $browser_info['version'];
            break;
        }
    }

    // 操作系统检测规则
    $oses = [
        // 增强 Android 版本识别（专门优化夸克浏览器支持）
        '/(?:Android|Adr)(?:\s|\/)([\d.]+)/i' => function($matches) {
            $version = floatval($matches[1]);
            $android_versions = [
                15 => 'Android 15',
                14 => 'Android 14',
                13 => 'Android 13',
                12 => 'Android 12',
                11 => 'Android 11',
                10 => 'Android 10',
                9 => 'Android 9 (Pie)',
                8 => 'Android 8 (Oreo)',
                7 => 'Android 7 (Nougat)',
                6 => 'Android 6 (Marshmallow)',
                5 => 'Android 5 (Lollipop)',
                4 => 'Android 4 (KitKat)',
            ];

            foreach ($android_versions as $major => $name) {
                if ($version >= $major && $version < $major + 1) {
                    return $name;
                }
            }

            return "Android $version";
        },
        // Windows 识别增强
        '/Windows NT 10.0; Win64; x64.*? rv:([\d.]+)/i' => 'Windows 11',
        '/Windows NT 10.0; Win64; x64/i' => 'Windows 11',
        '/Windows NT 10.0/i' => 'Windows 10',
        '/Windows NT 6.1/i' => 'Windows 7',
        '/Windows NT 6.2|6.3/i' => 'Windows 8/8.1',
        // macOS 版本提取
        '/Mac OS X (\d+)_(\d+)(?:_(\d+))?/i' => function($matches) {
            $version = "{$matches[1]}.{$matches[2]}";
            if (isset($matches[3])) {
                $version .= ".{$matches[3]}";
            }

            $mac_versions = [
                '10.15' => 'macOS Catalina',
                '11.0' => 'macOS Big Sur',
                '12.0' => 'macOS Monterey',
                '13.0' => 'macOS Ventura',
                '14.0' => 'macOS Sonoma',
            ];

            return $mac_versions[$version] ?? "macOS $version";
        },
        // 其他系统
        '/Linux/i' => 'Linux',
        '/(iPhone|iPad); CPU (?:iPhone )?OS (\d+)_(\d+)(?:_(\d+))?/i' => function($matches) {
            $device = $matches[1];
            $version = "{$matches[2]}.{$matches[3]}";
            if (isset($matches[4])) {
                $version .= ".{$matches[4]}";
            }
            return $device === 'iPad' ? "iPadOS $version" : "iOS $version";
        },
        '/watchOS (\d+)\.(\d+)(?:\.(\d+))?/i' => function($matches) {
            $version = "{$matches[1]}.{$matches[2]}";
            if (isset($matches[3])) {
                $version .= ".{$matches[3]}";
            }
            return "watchOS $version";
        },
        '/tvOS (\d+)\.(\d+)(?:\.(\d+))?/i' => function($matches) {
            $version = "{$matches[1]}.{$matches[2]}";
            if (isset($matches[3])) {
                $version .= ".{$matches[3]}";
            }
            return "tvOS $version";
        },
        '/Chrome OS/i' => 'Chrome OS',
        '/Firefox OS/i' => 'Firefox OS',
    ];

    foreach ($oses as $pattern => $processor) {
        if (is_callable($processor)) {
            if (preg_match($pattern, $user_agent, $matches)) {
                $result['os'] = $processor($matches);
                break;
            }
        } else {
            if (preg_match($pattern, $user_agent)) {
                $result['os'] = $processor;
                break;
            }
        }
    }

    return $result;
}

// 获取用户的真实IP
$visitor_ip = get_client_ip();

// 构造API请求URL
$ip_api_url = "https://api.ipdatacloud.com/v2/query?ip=" . urlencode($visitor_ip) . "&key=7054494a23ad11efb75000163e167ffb&full_name=1";

// 获取IP信息
$ip_data = get_ip_info($ip_api_url);

// 解析地理位置信息
$province = $ip_data['data']['location']['province'] ?? "";
$city = $ip_data['data']['location']['city'] ?? "";
$district = $ip_data['data']['location']['district'] ?? "";

// 组合地址
$location_parts = array_filter([$province, $city, $district]);
$full_location = implode("", $location_parts);

// 获取并解析用户代理信息
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? "";
$ua_info = parse_user_agent($user_agent);

// 获取当前日期和星期
$date = date("Y年m月d日");
$weekdays = ['日', '一', '二', '三', '四', '五', '六'];
$weekday = $weekdays[(int)date("w")];
$date_with_weekday = "{$date} 星期{$weekday}";

// 构建响应数据
$response = [
    "code" => 200,
    "msg" => "请求成功",
    "data" => [
        "ip" => $visitor_ip,
        "location" => $full_location,
        "browser" => $ua_info['browser'],
        "browser_version" => $ua_info['browser_ver'],
        "os" => $ua_info['os'],
        "date" => $date_with_weekday
    ],
    "exec_time" => round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 6)
];

// 开发环境添加调试信息
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') {
    $response['debug'] = $ip_data['error'] ?? '';
}

// 输出响应数据
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>