<?php

namespace NineDigit\eKasa\Client\Models\Storage;

/**
 * Informácie o pripojenom zariadení
 */
final class StorageDeviceDto{
    /**
     * Názov výrobcu získaného zo zbernice
     */
    public ?string $vendorName;

    /**
     * Identifikátor výrobcu získaný zo zbernice
     */
    public ?int $vendorId;

    /**
     * Názov produktu získaný zo zbernice
     */
    public ?string $productName;

    /**
     * Identifikátor produktu získaný zo zbernice
     */
    public ?int $productId;

    /**
     * Adresa sérového portu, na ktorom je chránené dátové úložisko pripojené
     */
    public ?string $serialPortName;

    /**
     * Identifikátor modelu chráneného dátového úložiska
     * @see StorageModel
     */
    public ?string $storageModel;
}