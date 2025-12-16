<?php

namespace Tests;

use PHPUnit\Framework\TestResult;
use PHPUnit\TextUI\DefaultResultPrinter;

class CustomTestResultPrinter extends DefaultResultPrinter
{
    private $testResults = [];
    private $currentModule = '';

    public function startTest(\PHPUnit\Framework\Test $test): void
    {
        parent::startTest($test);
        
        $testName = $test->getName();
        $className = get_class($test);
        
        // Extract module name from class name
        if (preg_match('/Modul(.+)Test$/', $className, $matches)) {
            $this->currentModule = 'Modul ' . $matches[1];
        }
        
        $this->testResults[] = [
            'module' => $this->currentModule,
            'test' => $this->formatTestName($testName),
            'class' => $className,
            'status' => 'RUNNING',
            'type' => $this->getTestType($testName),
        ];
    }

    public function endTest(\PHPUnit\Framework\Test $test, float $time): void
    {
        parent::endTest($test, $time);
        
        $lastIndex = count($this->testResults) - 1;
        
        if ($this->testResults[$lastIndex]['status'] === 'RUNNING') {
            $this->testResults[$lastIndex]['status'] = 'PASSED';
            $this->testResults[$lastIndex]['result'] = 'Berhasil';
        }
    }

    public function addError(\PHPUnit\Framework\Test $test, \Throwable $t, float $time): void
    {
        parent::addError($test, $t, $time);
        $this->updateLastTestStatus('ERROR', 'Error');
    }

    public function addFailure(\PHPUnit\Framework\Test $test, \PHPUnit\Framework\AssertionFailedError $e, float $time): void
    {
        parent::addFailure($test, $e, $time);
        $this->updateLastTestStatus('FAILED', 'Gagal');
    }

    private function updateLastTestStatus(string $status, string $result): void
    {
        $lastIndex = count($this->testResults) - 1;
        if ($lastIndex >= 0) {
            $this->testResults[$lastIndex]['status'] = $status;
            $this->testResults[$lastIndex]['result'] = $result;
        }
    }

    private function formatTestName(string $name): string
    {
        // Convert snake_case to readable text
        $formatted = str_replace('_', ' ', $name);
        return ucfirst($formatted);
    }

    private function getTestType(string $testName): string
    {
        if (strpos($testName, 'integration') !== false) {
            return 'Integration';
        } elseif (strpos($testName, 'unit') !== false) {
            return 'Unit';
        } else {
            return 'Functional';
        }
    }

    public function printResult(\PHPUnit\Framework\TestResult $result): void
    {
        parent::printResult($result);
        
        $this->write("\n\n");
        $this->printTable();
    }

    private function printTable(): void
    {
        $this->write("┌" . str_repeat("─", 150) . "┐\n");
        $this->write(sprintf(
            "│ %-3s │ %-80s │ %-15s │ %-15s │ %-15s │\n",
            "No",
            "Nama Test Case",
            "Jenis",
            "Status",
            "Hasil"
        ));
        $this->write("├" . str_repeat("─", 150) . "┤\n");

        $currentModule = '';
        $no = 1;

        foreach ($this->testResults as $test) {
            if ($currentModule !== $test['module']) {
                $this->write("├" . str_repeat("─", 150) . "┤\n");
                $this->write(sprintf("│ %-148s │\n", " " . $test['module']));
                $this->write("├" . str_repeat("─", 150) . "┤\n");
                $currentModule = $test['module'];
            }

            $statusColor = $test['status'] === 'PASSED' ? "\033[32m✓\033[0m" : "\033[31m✗\033[0m";
            $resultColor = $test['result'] === 'Berhasil' ? "\033[32m" . $test['result'] . "\033[0m" : "\033[31m" . $test['result'] . "\033[0m";

            $this->write(sprintf(
                "│ %-3d │ %-80s │ %-15s │ %-15s │ %-15s │\n",
                $no++,
                $test['test'],
                $test['type'],
                $statusColor . " " . $test['status'],
                $resultColor
            ));
        }

        $this->write("└" . str_repeat("─", 150) . "┘\n");
    }
}
