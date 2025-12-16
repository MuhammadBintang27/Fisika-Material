<?php

namespace Tests;

use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\TestSuite;
use PHPUnit\TextUI\DefaultResultPrinter;

class TestReporter extends DefaultResultPrinter
{
    protected $testResults = [];
    protected $currentModule = '';
    
    public function startTestSuite(TestSuite $suite): void
    {
        parent::startTestSuite($suite);
        
        $suiteName = $suite->getName();
        if (strpos($suiteName, 'Modul') !== false) {
            $this->currentModule = $this->formatModuleName($suiteName);
        }
    }
    
    public function endTest(Test $test, float $time): void
    {
        parent::endTest($test, $time);
        
        $testName = $test->getName();
        $status = $test->getStatus();
        $result = $this->getTestResult($status);
        
        $this->testResults[] = [
            'module' => $this->currentModule,
            'name' => $this->formatTestName($testName),
            'type' => $this->getTestType($testName),
            'status' => $result['status'],
            'result' => $result['result']
        ];
    }
    
    public function printResult(TestResult $result): void
    {
        parent::printResult($result);
        
        $this->write("\n\n");
        $this->printTableReport();
    }
    
    protected function printTableReport(): void
    {
        $this->write("\n╔════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗\n");
        $this->write("║                                    Modul Admin Content Management                                                ║\n");
        $this->write("╠════╦═══════════════════════════════════════════════════════════════╦════════════════╦════════════════╦═══════════╣\n");
        $this->write("║ No ║ Nama Test Case                                                ║ Jenis          ║ Status         ║ Hasil     ║\n");
        $this->write("╠════╬═══════════════════════════════════════════════════════════════╬════════════════╬════════════════╬═══════════╣\n");
        
        $groupedResults = $this->groupByModule($this->testResults);
        $no = 1;
        
        foreach ($groupedResults as $module => $tests) {
            foreach ($tests as $test) {
                $status = $test['status'] === 'PASSED' ? "\033[32m✓ PASSED\033[0m" : "\033[31m✗ FAILED\033[0m";
                $hasil = $test['result'] === 'Berhasil' ? "\033[32mBerhasil\033[0m" : "\033[31mGagal\033[0m";
                
                $this->write(sprintf(
                    "║ %-2d ║ %-64s ║ %-14s ║ %-22s ║ %-17s ║\n",
                    $no++,
                    $this->truncate($test['name'], 64),
                    $test['type'],
                    $status,
                    $hasil
                ));
            }
        }
        
        $this->write("╚════╩═══════════════════════════════════════════════════════════════╩════════════════╩════════════════╩═══════════╝\n");
    }
    
    protected function groupByModule(array $results): array
    {
        $grouped = [];
        foreach ($results as $result) {
            $module = $result['module'] ?: 'Other';
            if (!isset($grouped[$module])) {
                $grouped[$module] = [];
            }
            $grouped[$module][] = $result;
        }
        return $grouped;
    }
    
    protected function formatModuleName(string $name): string
    {
        return str_replace('Tests\\Feature\\', '', $name);
    }
    
    protected function formatTestName(string $name): string
    {
        return str_replace('_', ' ', $name);
    }
    
    protected function getTestType(string $name): string
    {
        if (strpos($name, 'validasi') !== false || strpos($name, 'validation') !== false) {
            return 'Validation';
        } elseif (strpos($name, 'relasi') !== false || strpos($name, 'relation') !== false) {
            return 'Integration';
        } elseif (strpos($name, 'unit') !== false) {
            return 'Unit';
        } else {
            return 'Functional';
        }
    }
    
    protected function getTestResult(int $status): array
    {
        if ($status === \PHPUnit\Runner\BaseTestRunner::STATUS_PASSED) {
            return ['status' => 'PASSED', 'result' => 'Berhasil'];
        } else {
            return ['status' => 'FAILED', 'result' => 'Gagal'];
        }
    }
    
    protected function truncate(string $text, int $length): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length - 3) . '...';
    }
}
