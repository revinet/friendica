<?php

namespace Friendica\Object;

use Friendica\Object\EMail\IEmail;

/**
 * The default implementation of the IEmail interface
 *
 * Provides the possibility to reuse the email instance with new recipients (@see Email::withRecipient())
 */
class Email implements IEmail
{
	/** @var string */
	private $fromName;
	/** @var string */
	private $fromAddress;
	/** @var string */
	private $replyTo;

	/** @var string */
	private $toAddress;

	/** @var string */
	private $subject;
	/** @var string|null */
	private $msgHtml;
	/** @var string */
	private $msgText;

	/** @var string */
	private $additionalMailHeader = '';
	/** @var int|null */
	private $toUid = null;

	public function __construct(string $fromName, string $fromAddress, string $replyTo, string $toAddress,
	                            string $subject, string $msgHtml, string $msgText,
	                            string $additionalMailHeader = '', int $toUid = null)
	{
		$this->fromName             = $fromName;
		$this->fromAddress          = $fromAddress;
		$this->replyTo              = $replyTo;
		$this->toAddress            = $toAddress;
		$this->subject              = $subject;
		$this->msgHtml              = $msgHtml;
		$this->msgText              = $msgText;
		$this->additionalMailHeader = $additionalMailHeader;
		$this->toUid                = $toUid;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFromName()
	{
		return $this->fromName;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFromAddress()
	{
		return $this->fromAddress;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getReplyTo()
	{
		return $this->replyTo;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getToAddress()
	{
		return $this->toAddress;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMessage(bool $plain = false)
	{
		if ($plain) {
			return $this->msgText;
		} else {
			return $this->msgHtml;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAdditionalMailHeader()
	{
		return $this->additionalMailHeader;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRecipientUid()
	{
		return $this->toUid;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withRecipient(string $address, int $uid = null)
	{
		$newEmail            = clone $this;
		$newEmail->toAddress = $address;
		$newEmail->toUid     = $uid;

		return $newEmail;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withMessage(string $plaintext, string $html = null)
	{
		$newMail          = clone $this;
		$newMail->msgText = $plaintext;
		$newMail->msgHtml = $html;

		return $newMail;
	}

	/**
	 * Returns the properties of the email as an array
	 *
	 * @return array
	 */
	private function toArray()
	{
		return get_object_vars($this);
	}

	/**
	 * @inheritDoc
	 */
	public function __toString()
	{
		return json_encode($this->toArray());
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}
}
