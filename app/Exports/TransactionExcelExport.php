<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use ZipArchive;

class TransactionExcelExport
{
    public function __construct(protected Collection $transactions)
    {
    }

    public function download(string $filename = 'transactions.xlsx')
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'transactions');

        if ($tempPath === false) {
            abort(500, 'Unable to create temporary file.');
        }

        $xlsxPath = $tempPath . '.xlsx';
        rename($tempPath, $xlsxPath);

        $this->build($xlsxPath);

        return response()->download($xlsxPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    protected function build(string $path): void
    {
        $rows = [
            ['Kode Transaksi', 'User', 'Deskripsi', 'Tipe', 'Jumlah', 'Metode Pembayaran', 'Status', 'Tanggal'],
        ];

        foreach ($this->transactions as $transaction) {
            $rows[] = [
                $transaction->transaction_code,
                $transaction->user?->name ?? '-',
                $transaction->description,
                $this->formatType($transaction->type),
                (string) $transaction->amount,
                $this->formatPaymentMethod($transaction->payment_method),
                $this->formatStatus($transaction->status),
                $transaction->created_at?->format('d/m/Y H:i:s') ?? '-',
            ];
        }

        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addFromString('[Content_Types].xml', $this->buildContentTypesXml());
        $zip->addFromString('_rels/.rels', $this->buildRelationshipsXml());
        $zip->addFromString('docProps/app.xml', $this->buildAppXml());
        $zip->addFromString('docProps/core.xml', $this->buildCoreXml());
        $zip->addFromString('xl/workbook.xml', $this->buildWorkbookXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->buildWorkbookRelationshipsXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->buildSheetXml($rows));
        $zip->addFromString('xl/styles.xml', $this->buildStylesXml());
        $zip->close();
    }

    protected function buildSheetXml(array $rows): string
    {
        $xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <sheetData>
XML;

        foreach ($rows as $rowIndex => $row) {
            $xml .= '<row r="' . ($rowIndex + 1) . '">';

            foreach ($row as $columnIndex => $value) {
                $cellReference = $this->columnLetter($columnIndex + 1) . ($rowIndex + 1);
                $xml .= '<c r="' . $cellReference . '" t="inlineStr"><is><t>' . $this->escapeXml((string) $value) . '</t></is></c>';
            }

            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';

        return $xml;
    }

    protected function buildWorkbookXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
 xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets>
    <sheet name="Transactions" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>
XML;
    }

    protected function buildWorkbookRelationshipsXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>
XML;
    }

    protected function buildStylesXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="1"><font><sz val="11"/><name val="Calibri"/><family val="2"/></font></fonts>
  <fills count="1"><fill><patternFill patternType="none"/></fill></fills>
  <borders count="1"><border/></borders>
  <cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>
  <cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/></cellXfs>
  <cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>
</styleSheet>
XML;
    }

    protected function buildContentTypesXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
  <Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>
  <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
</Types>
XML;
    }

    protected function buildRelationshipsXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
  <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>
</Relationships>
XML;
    }

    protected function buildAppXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties"
 xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
  <Application>Laravel</Application>
</Properties>
XML;
    }

    protected function buildCoreXml(): string
    {
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');

        return <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:dcterms="http://purl.org/dc/terms/"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <dc:title>Transactions Export</dc:title>
  <dc:creator>Laravel</dc:creator>
  <cp:revision>1</cp:revision>
  <dcterms:created xsi:type="dcterms:W3CDTF">{$timestamp}</dcterms:created>
  <dcterms:modified xsi:type="dcterms:W3CDTF">{$timestamp}</dcterms:modified>
</cp:coreProperties>
XML;
    }

    protected function columnLetter(int $index): string
    {
        $result = '';

        while ($index > 0) {
            $index--;
            $result = chr(65 + ($index % 26)) . $result;
            $index = intdiv($index, 26);
        }

        return $result;
    }

    protected function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    protected function formatType(string $type): string
    {
        return match ($type) {
            'income' => 'Pemasukan',
            'expense' => 'Pengeluaran',
            'transfer' => 'Transfer',
            default => $type,
        };
    }

    protected function formatPaymentMethod(string $paymentMethod): string
    {
        return match ($paymentMethod) {
            'cash' => 'Tunai',
            'transfer' => 'Transfer',
            'card' => 'Kartu',
            'check' => 'Cek',
            'other' => 'Lainnya',
            default => $paymentMethod,
        };
    }

    protected function formatStatus(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'completed' => 'Selesai',
            'failed' => 'Gagal',
            'cancelled' => 'Dibatalkan',
            default => $status,
        };
    }
}
