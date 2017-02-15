<?php

namespace SqlCs\Report;

final class ReportManager
{
    /**
     * Reports.
     *
     * @var Report[]
     */
    private $reports = array();

    public function getReports()
    {
        return $this->reports;
    }

    public function getErrorReports()
    {
        return array_filter($this->reports, function (Report $report) {
            return $report->getType() === Report::TYPE_ERROR;
        });
    }

    public function getValidReports()
    {
        return array_filter($this->reports, function (Report $report) {
            return $report->getType() === Report::TYPE_VALID;
        });
    }

    public function hasErrors()
    {
        return count($this->getErrorReports()) > 0;
    }

    /**
     * Add reports.
     *
     * @param Report $report
     */
    public function report(Report $report)
    {
        $this->reports[] = $report;
    }
}
