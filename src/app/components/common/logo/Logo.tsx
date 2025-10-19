import Image from 'next/image'
import { Link } from '@/i18n/navigation' // ✅ استخدام Link من next-intl
import React from 'react'

type Tlogo = {
  isDark?: boolean
}

const Logo: React.FC<Tlogo> = ({isDark}) => {
  return (
    <Link href="/" className="logo relative">
      <Image
        src={isDark ? "/images/logo/logo-rect-dark.svg" : "/images/logo/logo-rect-light.svg"}
        alt="Logo"
        width={150}
        height={100}
        priority
        style={{ height: "auto", width: "auto" }}
        className="h-14 w-auto"
      />
    </Link>
  )
}

export default Logo