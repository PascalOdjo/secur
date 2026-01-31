<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PaymentCalculatorService;

class PaymentCalculatorTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_calculate_daily_agent_pay()
    {
        $service = new PaymentCalculatorService();
        
        // Input: 128 (Exploitation)
        // Logique attendue:
        // 128 / 2 = 64 (Half)
        // 64 / 4 = 16 (Squad Base)
        // 16 / 16 = 1 (Daily Squad Value - 16 jours)
        // 1 / 4 = 0.25 (Part Agent - 4 postes/parts)
        
        $result = $service->calculateDailyAgentPay(128);

        $this->assertEquals(128, $result['exploitation']);
        $this->assertEquals(64, $result['half_exploitation']);
        $this->assertEquals(16, $result['squad_base']);
        $this->assertEquals(1, $result['daily_squad_value']);
        $this->assertEquals(0.25, $result['final_agent_pay']);
    }
}
