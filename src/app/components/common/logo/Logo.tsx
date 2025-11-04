import Image from 'next/image'
import { Link } from '@/i18n/navigation' 
import React from 'react'

type Tlogo = {
  isDark?: boolean
}

const Logo: React.FC<Tlogo> = ({isDark}) => {
  return (
    <Link href="/" className="logo relative block" style={{ width: '160px', height: '56px' }}>
      <Image
        src={isDark ? "/images/logo/logo-rect-dark.svg" : "/images/logo/logo-rect-light.svg"}
        alt="Logo"
        fill
        priority
        className="object-contain"
      />
    </Link>
  )
}

export default Logo